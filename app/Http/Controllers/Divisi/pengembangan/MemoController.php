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
}
