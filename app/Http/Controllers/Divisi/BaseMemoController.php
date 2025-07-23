<?php

namespace App\Http\Controllers\divisi;

use App\Http\Controllers\Controller;
use App\Models\Memo;
use App\Models\Divisi;
use Illuminate\Http\Request;

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
        $memos = Memo::where('divisi_tujuan', $this->divisiName)
                   ->where('dari', '!=', $this->divisiName)
                   ->orderBy('created_at', 'desc')
                   ->paginate(10);
        
        return view($this->viewPrefix . '.inbox', [
            'memos' => $memos,
            'routePrefix' => $this->routePrefix,
            'currentDivisi' => $this->divisiName
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
            'lampiran' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
        ]);

        $memoData = $request->only(['nomor', 'tanggal', 'kepada', 'perihal', 'divisi_tujuan', 'isi']);
        $memoData['dari'] = $this->divisiName;
        $memoData['dibuat_oleh_user_id'] = auth()->id();

        if ($request->hasFile('lampiran')) {
            $memoData['lampiran'] = $request->file('lampiran')->store('lampiran', 'public');
        }

        Memo::create($memoData);

        return redirect()->route($this->routePrefix . '.memo.index')
               ->with('success', 'Memo berhasil dibuat');
    }
}