<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\MemoLog;
use App\Models\Divisi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

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

        $memoData = $request->only([
            'nomor', 'tanggal', 'kepada', 'kepada_id', 'perihal', 
            'divisi_tujuan', 'isi'
        ]);
        
        $memoData['dari'] = auth()->user()->divisi->nama;
        $memoData['dibuat_oleh_user_id'] = auth()->id();
        $memoData['status'] = 'diajukan';

        $memo = Memo::create($memoData);

        MemoLog::create([
            'memo_id' => $memo->id,
            'divisi' => auth()->user()->divisi->nama,
            'aksi' => 'pembuatan',
            'catatan' => 'Memo dibuat oleh ' . auth()->user()->name,
            'user_id' => auth()->id(),
            'waktu' => now()->toDateTimeString(),
        ]);

        return redirect()->route('staff.memo.index')
            ->with('success', 'Memo berhasil dibuat dan diajukan');
    }

    public function edit($id)
{
    $memo = Memo::findOrFail($id);
    
    // Authorization check - memo must be from user's division
    if ($memo->dari !== auth()->user()->divisi->nama) {
        abort(403, 'Anda tidak memiliki akses ke memo ini.');
    }

    // Only allow editing if status is draft or needs revision
    if (!in_array($memo->status, ['draft', 'revisi'])) {
        return redirect()->route('staff.memo.index')
            ->with('error', 'Hanya memo dengan status draft atau revisi yang dapat diedit');
    }

    return view('memo.edit', [
        'memo' => $memo,
        'routePrefix' => 'staff'
    ]);
}

    public function update(Request $request, $id)
{
    $memo = Memo::findOrFail($id);
    $user = auth()->user();

    // Authorization check
    if ($memo->dari !== $user->divisi->nama) {
        abort(403, 'Memo tidak berasal dari divisi Anda.');
    }

    // Validate input
    $validated = $request->validate([
        'nomor' => 'required|string|max:50|unique:memos,nomor,'.$id,
        'tanggal' => 'required|date',
        'kepada' => 'required|string|max:100',
        'kepada_id' => 'required|exists:users,id',
        'perihal' => 'required|string|max:255',
        'divisi_tujuan' => 'required|string',
        'isi' => 'required|string',
    ]);

    // Update memo data
    $memo->update(array_merge($validated, [
        'status' => 'diajukan', // Reset status to 'diajukan'
        'approved_by' => null,
        'approval_date' => null,
        'revision_requested_by' => null,
        'revision_requested_at' => null
    ]));

    // Create log
    MemoLog::create([
        'memo_id' => $memo->id,
        'user_id' => $user->id,
        'divisi' => $user->divisi->nama,
        'aksi' => $memo->wasRecentlyCreated ? 'pembuatan' : 'pengajuan_ulang',
        'catatan' => 'Memo diajukan oleh ' . $user->name,
        'waktu' => now(),
    ]);

    // Regenerate PDF
    $this->regeneratePdf($memo->id);

    return redirect()->route('staff.memo.index')
        ->with('success', 'Memo berhasil diperbarui dan diajukan');
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
        
        $pdf->save(storage_path('app/public/'.$path));
        
        $memo->update(['pdf_path' => $path]);
        
        return $path;
    }
}