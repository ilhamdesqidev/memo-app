<?php

namespace App\Http\Controllers\divisi;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\Divisi;
use Illuminate\Http\Request;
use App\Models\MemoLog;

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
            'manager' => 'manager'
        ];
        
        $this->routePrefix = $specialCases[$nama] ?? $nama;
    }

    public function index()
    {
        $memos = Memo::where('dari', $this->divisiName)
                   ->orderBy('created_at', 'desc')
                   ->paginate(10);
        
        return view($this->viewPrefix . '.index', [
            'memos' => $memos,
            'routePrefix' => $this->routePrefix,
            'currentDivisi' => $this->divisiName
        ]);
    }

    public function inbox()
{
    $divisiTujuan = $this->getDivisiTujuan(); // <--- Tambahkan baris ini

    $memos = Memo::where('divisi_tujuan', $this->divisiName)
                ->where('dari', '!=', $this->divisiName)
                ->where('status', '!=', 'ditolak') // Optional filter status
                ->orderBy('created_at', 'desc')
                ->paginate(10);
    
    return view($this->viewPrefix . '.inbox', [
        'memos' => $memos,
        'routePrefix' => $this->routePrefix,
        'currentDivisi' => $this->divisiName,
        'divisiTujuan' => $divisiTujuan, // <--- Kirim ke view
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
            'perihal' => 'required|string|max:255',
            'divisi_tujuan' => 'required|string',
            'isi' => 'required|string',
            'lampiran' => 'nullable|integer|min:0|max:10', // Updated validation
        ]);

        $memoData = $request->only(['nomor', 'tanggal', 'kepada', 'perihal', 'divisi_tujuan', 'isi', 'lampiran']); // Include lampiran
        $memoData['dari'] = $this->divisiName;
        $memoData['dibuat_oleh_user_id'] = auth()->id();

        Memo::create($memoData);

        return redirect()->route($this->routePrefix . '.memo.index')
            ->with('success', 'Memo berhasil dibuat');
    }

    public function updateStatus(Request $request)
{
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
        }
        $memo->status = 'disetujui';
        $memo->approved_by = auth()->id();
        $memo->approval_date = now();
    } elseif ($action === 'tolak') {
        $request->validate(['alasan' => 'required|string']);
        $memo->status = 'ditolak';
        $catatan = $request->alasan;
        $memo->alasan = $catatan;
    } elseif ($action === 'revisi') {
        $request->validate(['catatan_revisi' => 'required|string']);
        $memo->status = 'revisi';
        $catatan = $request->catatan_revisi;
        $memo->catatan_revisi = $catatan;
    }

    $memo->save();

    // Simpan log jejak
    MemoLog::create([
        'memo_id' => $memo->id,
        'divisi' => $this->divisiName,
        'aksi' => $action,
        'catatan' => $catatan,
        'user_id' => auth()->id(),
        'waktu' => now(),
    ]);

    return redirect()->back()->with('success', 'Status memo berhasil diperbarui.');
}


protected function getDivisiTujuan()
{
    return Divisi::where('nama', '!=', auth()->user()->divisi->nama)->get();
}
}