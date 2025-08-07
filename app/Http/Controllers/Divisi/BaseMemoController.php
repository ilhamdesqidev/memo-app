<?php

namespace App\Http\Controllers\divisi;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Models\MemoLog;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class BaseMemoController extends Controller
{
    protected $divisiName;
    protected $viewPrefix;
    protected $routePrefix;

    public function __construct()
    {
        $this->setRoutePrefix();
    }

    protected function setRoutePrefix()
    {
        $nama = strtolower(str_replace(' ', '', $this->divisiName));
        
        $specialCases = [
            'pengembanganbisnis' => 'pengembangan',
            'operasionalwilayahi' => 'opwil1',
            'operasionalwilayahii' => 'opwil2',
            'umumdanlegal' => 'umumlegal',
            'administrasidankeuangan' => 'adminkeu',
            'infrastrukturdansipil' => 'sipil',
            'foodbeverage' => 'food',
            'marketingdansales' => 'marketing',
        ];
        
        $this->routePrefix = $specialCases[$nama] ?? $nama;
    }

    public function index()
    {
        $memos = Memo::where('dari', $this->divisiName)
                   ->where('dibuat_oleh_user_id', auth()->id())
                   ->orderBy('created_at', 'desc')
                   ->paginate(10);
        
        return view($this->viewPrefix . '.index', [
            'memos' => $memos,
            'routePrefix' => $this->routePrefix,
            'currentDivisi' => $this->divisiName,
            'title' => 'Memo Keluar'
        ]);
    }

    public function inbox()
    {
        $divisiTujuan = $this->getDivisiTujuan();

        $memos = Memo::where('divisi_tujuan', $this->divisiName)
                    ->where('dari', '!=', $this->divisiName)
                    ->whereIn('status', ['diajukan', 'revisi'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return view($this->viewPrefix . '.inbox', [
            'memos' => $memos,
            'routePrefix' => $this->routePrefix,
            'currentDivisi' => $this->divisiName,
            'divisiTujuan' => $divisiTujuan,
            'title' => 'Memo Masuk',
            'inbox' => true
        ]);
    }

    public function show($id)
    {
        $memo = Memo::findOrFail($id);

        if ($memo->divisi_tujuan !== $this->divisiName && 
            $memo->dari !== $this->divisiName) {
            abort(403, 'Unauthorized action.');
        }

        return view($this->viewPrefix . '.show', [
            'memo' => $memo,
            'routePrefix' => $this->routePrefix
        ]);
    }

    public function create()
    {
        $divisiTujuan = Divisi::where('nama', '!=', $this->divisiName)->get();
        return view('memo.create', [
            'divisiTujuan' => $divisiTujuan,
            'routePrefix' => $this->routePrefix
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
        'divisi_tujuan' => 'required|string',
        'isi' => 'required|string',
    ]);

    // Verify that the selected user is an asisten_manager
    $penerima = \App\Models\User::findOrFail($request->kepada_id);
    if ($penerima->role !== 'asisten_manager') {
        return back()->withErrors(['kepada_id' => 'Penerima harus seorang Asisten Manager'])->withInput();
    }

    $memoData = $request->only([
        'nomor', 'tanggal', 'kepada', 'kepada_id', 'perihal', 
        'divisi_tujuan', 'isi'
    ]);
    
    $memoData['dari'] = $this->divisiName;
    $memoData['dibuat_oleh_user_id'] = auth()->id();
    $memoData['status'] = 'diajukan';
    $memoData['divisi_tujuan'] = $penerima->divisi->nama;

    $memo = Memo::create($memoData);

    MemoLog::create([
        'memo_id' => $memo->id,
        'divisi' => $this->divisiName,
        'aksi' => 'pembuatan',
        'catatan' => 'Memo dibuat oleh ' . auth()->user()->name,
        'user_id' => auth()->id(),
        'waktu' => now()->toDateTimeString(),
    ]);

    return redirect()->route($this->routePrefix . '.memo.index')
        ->with('success', 'Memo berhasil dibuat dan diajukan');
}

    public function edit($id)
    {
        $memo = Memo::findOrFail($id);
        
        // Authorization check yang lebih fleksibel
        if ($memo->dari !== $this->divisiName) {
            abort(403, 'Anda tidak memiliki akses ke memo ini.');
        }

        // Tambahkan pengecekan role jika diperlukan
        $user = auth()->user();
        if (!in_array($user->role, ['user', 'asisten_manager'])) {
            abort(403, 'Hanya anggota divisi yang dapat mengedit memo.');
        }

        $divisiTujuan = Divisi::where('nama', '!=', $this->divisiName)->get();
        $users = \App\Models\User::where('divisi_id', '!=', $user->divisi_id)
                    ->where('id', '!=', $user->id)
                    ->get();
        
        return view('memo.edit', [
            'memo' => $memo,
            'divisiTujuan' => $divisiTujuan,
            'users' => $users,
            'routePrefix' => $this->routePrefix,
            'currentDivisi' => $this->divisiName
        ]);
    }

    public function update(Request $request, $id)
    {
        $memo = Memo::findOrFail($id);
        $user = auth()->user();

        // Validasi otorisasi
        if ($memo->dari !== $user->divisi->nama) {
            abort(403, 'Memo tidak berasal dari divisi Anda.');
        }

        // Validasi input
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

        // Update data memo dan langsung ajukan
        $memo->update(array_merge($validated, [
            'status' => 'diajukan',
            'approved_by' => null,
            'approval_date' => null
        ]));

        // Log perubahan
        MemoLog::create([
            'memo_id' => $memo->id,
            'divisi' => $this->divisiName,
            'aksi' => 'pengajuan_ulang',
            'catatan' => 'Memo diajukan kembali oleh ' . $user->name,
            'user_id' => $user->id,
            'waktu' => now()->toDateTimeString(),
        ]);

        // Regenerate PDF
        $this->regeneratePdf($memo->id);

        return redirect()->route($this->routePrefix . '.memo.index')
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

        if ($memo->divisi_tujuan !== $this->divisiName) {
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
            'divisi' => $this->divisiName,
            'aksi' => $action,
            'catatan' => $catatan,
            'user_id' => auth()->id(),
            'waktu' => now()->toDateTimeString(),
        ]);

        $this->regeneratePdf($memo->id);

        return redirect()->back()->with('success', 'Status memo berhasil diperbarui.');
    }

    protected function getDivisiTujuan()
    {
        return Divisi::where('nama', '!=', auth()->user()->divisi->nama)->get();
    }

    public function generatePdf($id)
    {
        $memo = Memo::findOrFail($id);
        
        $pdf = PDF::loadView('memo.pdf', compact('memo'));
        
        $folder = storage_path('app/public/memo_pdfs');
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }
        
        $filename = 'memo_'.$id.'_'.time().'.pdf';
        $path = 'memo_pdfs/'.$filename;
        $fullPath = storage_path('app/public/'.$path);
        
        $pdf->save($fullPath);
        
        $memo->update(['pdf_path' => $path]);
        
        return $path;
    }

    public function viewPdf($id)
    {
        $memo = Memo::findOrFail($id);
        $pdf = PDF::loadView('memo.pdf', compact('memo'));
        return $pdf->stream('memo.pdf');
    }

    protected function regeneratePdf($memoId)
    {
        $memo = Memo::with(['logs', 'disetujuiOleh', 'ditandatanganiOleh'])->findOrFail($memoId);
        
        if ($memo->pdf_path && Storage::exists('public/'.$memo->pdf_path)) {
            Storage::delete('public/'.$memo->pdf_path);
        }
        
        $pdf = PDF::loadView('memo.pdf', compact('memo'));
        
        $filename = 'memo_'.$memoId.'_'.time().'.pdf';
        $path = 'memo_pdfs/'.$filename;
        
        if (!Storage::exists('public/memo_pdfs')) {
            Storage::makeDirectory('public/memo_pdfs');
        }
        
        Storage::put('public/'.$path, $pdf->output());
        
        $memo->update(['pdf_path' => $path]);
        
        return $path;
    }
}