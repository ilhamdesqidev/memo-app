<?php

namespace App\Http\Controllers\Divisi\food;

use App\Http\Controllers\Divisi\BaseMemoController;
use App\Models\Memo;

class MemoController extends BaseMemoController
{
    /**
     * Tampilkan semua memo yang dikirim oleh divisi Marketing
     */
    public function __construct()
    {
        $this->divisiName = 'Food Beverage';
        $this->viewPrefix = 'divisi.food.memo';
    }
}
