<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\Divisi;
use App\Models\User;
use App\Models\MemoLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MemoController extends Controller
{
    protected $divisiName;
    protected $viewPrefix = 'staff.memo';
    protected $routePrefix = 'staff';

    public function __construct()
    {
        $this->divisiName = auth()->user()->divisi->nama;
    }

    public function index()
    {
        $memos = Memo::where('dibuat_oleh_user_id', auth()->id())
                   ->orderBy('created_at', 'desc')
                   ->paginate(10);
        
        return view($this->viewPrefix . '.index', [
            'memos' => $memos,
            'title' => 'Memo Keluar',
            'routePrefix' => $this->routePrefix,
            'currentDivisi' => $this->divisiName
        ]);
    }

    public function inbox()
    {
        $memos = Memo::where('divisi_tujuan', auth()->user()->divisi->nama)
                    ->where('dari', '!=', auth()->user()->divisi->nama)
                    ->whereIn('status', ['diajukan', 'revisi'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return view('staff.memo.inbox', [
            'memos' => $memos,
            'title' => 'Memo Masuk',
            'inbox' => true
        ]);
    }

    public function show($id)
    {
        $memo = Memo::findOrFail($id);

        if ($memo->divisi_tujuan !== auth()->user()->divisi->nama && 
            $memo->dari !== auth()->user()->divisi->nama) {
            abort(403, 'Unauthorized action.');
        }

        return view('staff.memo.show', [
            'memo' => $memo
        ]);
    }

    public function create()
    {
        $divisiTujuan = Divisi::where('nama', '!=', auth()->user()->divisi->nama)->get();
        return view('memo.create', [
            'routePrefix' => 'staff'
        ]);
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nomor' => 'required|string|max:50|unique:memos',
        'tanggal' => 'required|date',
        'kepada' => 'required|string|max:100',
        'kepada_id' => 'required|exists:users,id',
        'perihal' => 'required|string|max:255',
        'divisi_tujuan' => 'required|string|in:' . auth()->user()->divisi->nama, // Hanya boleh memilih divisi sendiri
        'isi' => 'required|string',
        'lampiran' => 'nullable|integer|min:0|max:10',
    ]);

    // Validasi penerima harus asisten manager dari divisi yang sama
    $penerima = User::findOrFail($request->kepada_id);
    if ($penerima->role !== 'asisten_manager' || $penerima->divisi_id !== auth()->user()->divisi_id) {
        return back()->withErrors([
            'kepada_id' => 'Penerima harus seorang Asisten Manager dari divisi Anda'
        ])->withInput();
    }

    $memoData = $request->only([
        'nomor', 'tanggal', 'kepada', 'kepada_id', 'perihal', 
        'divisi_tujuan', 'isi', 'lampiran'
    ]);
    
    // Set data tambahan
    $memoData['dari'] = auth()->user()->divisi->nama;
    $memoData['dibuat_oleh_user_id'] = auth()->id();
    $memoData['status'] = 'diajukan';
    $memoData['approval_date'] = null;
    $memoData['approved_by'] = null;

    // Buat memo
    $memo = Memo::create($memoData);

    // Buat log memo
    MemoLog::create([
        'memo_id' => $memo->id,
        'divisi' => auth()->user()->divisi->nama,
        'aksi' => 'pembuatan',
        'catatan' => 'Memo dibuat oleh ' . auth()->user()->name,
        'user_id' => auth()->id(),
        'waktu' => now()->toDateTimeString(),
    ]);

    // Generate PDF pertama kali
    $this->generatePdf($memo->id);

    return redirect()->route('staff.memo.index')
        ->with('success', 'Memo berhasil dibuat dan diajukan');
}

    public function edit($id)
    {
        $memo = Memo::findOrFail($id);
        
        if ($memo->dari !== auth()->user()->divisi->nama) {
            abort(403, 'Anda tidak memiliki akses ke memo ini.');
        }

        $divisiTujuan = Divisi::where('nama', '!=', auth()->user()->divisi->nama)->get();
        
        return view('memo.edit', [
            'memo' => $memo,
            'divisiTujuan' => $divisiTujuan,
            'routePrefix' => 'staff'
        ]);
    }

    public function update(Request $request, $id)
    {
        $memo = Memo::findOrFail($id);
        $user = auth()->user();

        if ($memo->dari !== $user->divisi->nama) {
            abort(403, 'Memo tidak berasal dari divisi Anda.');
        }

        $validated = $request->validate([
            'nomor' => 'required|string|max:50|unique:memos,nomor,'.$id,
            'tanggal' => 'required|date',
            'kepada' => 'required|string|max:100',
            'kepada_id' => 'required|exists:users,id',
            'perihal' => 'required|string|max:255',
            'divisi_tujuan' => 'required|string',
            'isi' => 'required|string',
            'lampiran' => 'nullable|integer|min:0|max:10',
        ]);

        $memo->update(array_merge($validated, [
            'status' => 'diajukan',
            'approved_by' => null,
            'approval_date' => null
        ]));

        MemoLog::create([
            'memo_id' => $memo->id,
            'divisi' => $user->divisi->nama,
            'aksi' => 'pengajuan_ulang',
            'catatan' => 'Memo diajukan kembali oleh ' . $user->name,
            'user_id' => $user->id,
            'waktu' => now()->toDateTimeString(),
        ]);

        $this->regeneratePdf($memo->id);

        return redirect()->route('staff.memo.index')
            ->with('success', 'Memo berhasil diajukan kembali');
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'memo_id' => 'required|exists:memos,id',
            'action' => 'required|in:setujui,tolak,revisi',
            'next_divisi' => 'nullable|exists:divisis,nama',
            'alasan' => 'required_if:action,tolak',
            'catatan_revisi' => 'required_if:action,revisi'
        ]);

        $memo = Memo::findOrFail($request->memo_id);

        if ($memo->divisi_tujuan !== auth()->user()->divisi->nama) {
            abort(403, 'Unauthorized action.');
        }

        $action = $request->input('action');
        $catatan = null;

        if ($action === 'setujui') {
            if ($request->filled('next_divisi')) {
                $catatan = "Diteruskan ke divisi " . $request->next_divisi;
                $memo->divisi_tujuan = $request->next_divisi;
                $memo->status = 'diajukan';
                
                if (!$memo->signed_by) {
                    $memo->approved_by = null;
                    $memo->approval_date = null;
                }
            } else {
                $catatan = "Disetujui";
                $memo->status = 'disetujui';
                $memo->approved_by = auth()->id();
                $memo->approval_date = now()->toDateTimeString();
            }
            
            if ($request->has('include_signature') && !$memo->signed_by && auth()->user()->signature) {
                $memo->include_signature = true;
                $memo->signature_path = auth()->user()->signature;
                $memo->signed_by = auth()->id();
                $memo->signed_at = now()->toDateTimeString();
            }
        } 
        elseif ($action === 'tolak') {
            $memo->status = 'ditolak';
            $catatan = $request->alasan;
        } 
        elseif ($action === 'revisi') {
            $memo->status = 'revisi';
            $catatan = $request->catatan_revisi;
        }

        $memo->save();

        MemoLog::create([
            'memo_id' => $memo->id,
            'divisi' => auth()->user()->divisi->nama,
            'aksi' => $action,
            'catatan' => $catatan,
            'user_id' => auth()->id(),
            'waktu' => now()->toDateTimeString(),
        ]);

        $this->regeneratePdf($memo->id);

        return redirect()->back()->with('success', 'Status memo berhasil diperbarui.');
    }

    public function viewPdf($id)
    {
        $memo = Memo::with(['logs', 'disetujuiOleh', 'ditandatanganiOleh'])
                  ->findOrFail($id);
        
        if ($memo->dari !== auth()->user()->divisi->nama && 
            $memo->divisi_tujuan !== auth()->user()->divisi->nama) {
            abort(403, 'Unauthorized action.');
        }
    
        if (!$memo->pdf_path || !Storage::exists('public/'.$memo->pdf_path)) {
            $this->generatePdf($memo->id);
            $memo->refresh();
        }
        
        $pdf = PDF::loadView('memo.pdf', compact('memo'))
                 ->setPaper('a4')
                 ->setOption('isHtml5ParserEnabled', true)
                 ->setOption('isRemoteEnabled', true);
        
        return $pdf->stream('memo-'.$id.'.pdf');
    }

    public function generatePdf($id)
    {
        $memo = Memo::with(['disetujuiOleh', 'ditandatanganiOleh'])->findOrFail($id);
        
        $pdf = PDF::loadView('memo.pdf', compact('memo'))
                  ->setPaper('a4')
                  ->setOption('isHtml5ParserEnabled', true)
                  ->setOption('isRemoteEnabled', true);
        
        $folder = storage_path('app/public/memo_pdfs');
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }
        
        $filename = 'memo_'.$id.'.pdf';
        $path = 'memo_pdfs/'.$filename;
        $fullPath = storage_path('app/public/'.$path);
        
        $pdf->save($fullPath);
        
        $memo->update(['pdf_path' => $path]);
        
        return $path;
    }

    protected function regeneratePdf($memoId)
    {
        $memo = Memo::with(['disetujuiOleh', 'ditandatanganiOleh'])->findOrFail($memoId);
        
        if ($memo->pdf_path && Storage::exists('public/'.$memo->pdf_path)) {
            Storage::delete('public/'.$memo->pdf_path);
        }
        
        return $this->generatePdf($memoId);
    }
}