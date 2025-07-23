<?php

namespace App\Http\Controllers\Divisi\sipil;

use App\Http\Controllers\Divisi\BaseMemoController;
use App\Models\Memo;

class MemoController extends BaseMemoController
{
    /**
     * Tampilkan semua memo yang dikirim oleh divisi Marketing
     */
    public function __construct()
    {
        $this->divisiName = 'Infrastruktur dan Sipil';
        $this->viewPrefix = 'divisi.sipil.memo';
         parent::__construct();
    }
}
