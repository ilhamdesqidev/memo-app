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
}
