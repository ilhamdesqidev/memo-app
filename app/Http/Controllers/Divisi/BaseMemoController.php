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
            
            // Handle tanda tangan
            if ($request->has('include_signature') && auth()->user()->signature) {
                $memo->include_signature = true;
                $memo->signature_path = auth()->user()->signature;
                $memo->signed_by = auth()->id();
                $memo->signed_at = now();
            }
            
            $memo->status = 'disetujui';
            $memo->approved_by = auth()->id();
            $memo->approval_date = now();
        } elseif ($action === 'tolak') {
            // ... (kode sebelumnya)
        } elseif ($action === 'revisi') {
            // ... (kode sebelumnya)
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

        // Regenerate PDF jika ada perubahan
        if ($action === 'setujui' || $action === 'tolak') {
            $this->regeneratePdf($memo->id);
        }

        return redirect()->back()->with('success', 'Status memo berhasil diperbarui.');
    }


protected function getDivisiTujuan()
{
    return Divisi::where('nama', '!=', auth()->user()->divisi->nama)->get();
}

// In your controller (MemoController.php)
public function generatePdf($id)
{
    $memo = Memo::findOrFail($id);
    
    $pdf = PDF::loadView('memo.pdf', compact('memo'));
    
    // Pastikan folder exists
    $folder = storage_path('app/public/memo_pdfs');
    if (!file_exists($folder)) {
        mkdir($folder, 0755, true);
    }
    
    $filename = 'memo_'.$id.'_'.time().'.pdf';
    $path = 'memo_pdfs/'.$filename;
    $fullPath = storage_path('app/public/'.$path);
    
    $pdf->save($fullPath);
    
    // Update database
    $memo->update(['pdf_path' => $path]);
    
    return $path;
}

public function viewPdf($id)
{
    $memo = Memo::findOrFail($id);
    $pdf = PDF::loadView('memo.pdf', compact('memo'));
    return $pdf->stream('memo.pdf');
}

public function regeneratePdf($id)
{
    $memo = Memo::findOrFail($id);
    
    // Hapus PDF lama jika ada
    if ($memo->pdf_path && Storage::exists('public/'.$memo->pdf_path)) {
        Storage::delete('public/'.$memo->pdf_path);
    }
    
    // Generate PDF baru
    $pdfPath = $this->generatePdf($memo->id);
    
    return response()->json([
        'success' => true,
        'path' => $pdfPath
    ]);
}
}