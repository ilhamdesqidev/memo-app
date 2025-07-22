<?php

namespace App\Http\Controllers\Divisi\pengembangan;

use App\Http\Controllers\Divisi\BaseMemoController;
use App\Models\Memo;

class MemoController extends BaseMemoController
{
    public function __construct()
    {
        $this->divisiName = 'Pengembangan Bisnis';
        $this->viewPrefix = 'divisi.pengembangan.memo';
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
