<?php

namespace App\Http\Controllers\Divisi\adminkeu;

use App\Http\Controllers\Divisi\BaseMemoController;
use App\Models\Memo;

class MemoController extends BaseMemoController
{
    /**
     * Tampilkan semua memo yang dikirim oleh divisi Marketing
     */
    public function __construct()
    {
        $this->divisiName = 'Administrasi dan Keuangan';
        $this->viewPrefix = 'divisi.adminkeu.memo';
         parent::__construct();
    }
}
