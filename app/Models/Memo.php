<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{

    use HasFactory;

    protected $dates = ['tanggal']; // This will automatically cast the field to a Carbon instance
    protected $fillable = [
        'nomor',
        'tanggal',
        'kepada',
        'dari',
        'perihal',
        'isi',
        'signature',
        'status',
        'approved_by',
        'approval_date',
        'rejection_reason'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'approval_date' => 'datetime'
    ];

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }
}
