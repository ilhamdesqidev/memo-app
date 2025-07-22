<?php

namespace App\Http\Controllers\Divisi\Manager;

use App\Http\Controllers\Divisi\BaseMemoController;
use App\Models\Memo;

class MemoController extends BaseMemoController
{
    public function __construct()
    {
        $this->divisiName = 'Manager';
        $this->viewPrefix = 'divisi.manager.memo';
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