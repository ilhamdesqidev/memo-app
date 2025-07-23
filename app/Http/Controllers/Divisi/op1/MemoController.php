<?php

namespace App\Http\Controllers\Divisi\Op1;

use App\Http\Controllers\Divisi\BaseMemoController;
use App\Models\Memo;

class MemoController extends BaseMemoController
{
    public function __construct()
    {
        $this->divisiName = 'Operasional Wilayah I';
        $this->viewPrefix = 'divisi.opwil1.memo';
         parent::__construct();
    }
}
