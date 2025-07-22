<?php

namespace App\Http\Controllers\Divisi\Op2;

use App\Http\Controllers\Divisi\BaseMemoController;
use App\Models\Memo;

class MemoController extends BaseMemoController
{
    public function __construct()
    {
        $this->divisiName = 'Operasional Wilayah II';
        $this->viewPrefix = 'divisi.opwil2.memo';
    }

    // Bisa override method dari BaseMemoController jika diperlukan
    // Contoh: Tampilan khusus Manager
    public function show($id)
    {
        $memo = Memo::findOrFail($id);

        if ($memo->divisi_tujuan !== $this->divisiName && 
            $memo->dari !== $this->divisiName) {
            abort(403, 'Unauthorized action.');
        }

        return view($this->viewPrefix . '.show', compact('memo'));
    }
}
