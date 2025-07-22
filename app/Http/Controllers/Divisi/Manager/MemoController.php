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
}