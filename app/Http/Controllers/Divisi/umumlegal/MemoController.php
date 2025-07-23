<?php

namespace App\Http\Controllers\Divisi\umumlegal;

use App\Http\Controllers\Divisi\BaseMemoController;
use App\Models\Memo;

class MemoController extends BaseMemoController
{
    public function __construct()
    {
        $this->divisiName = 'Umum dan Legal';
        $this->viewPrefix = 'divisi.umumlegal.memo';
         parent::__construct();
    }
}
