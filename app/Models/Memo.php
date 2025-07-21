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
    'lampiran',
    'divisi_tujuan',
    'dibuat_oleh_user_id'
];

// Add relationship to user
public function dibuatOleh()
{
    return $this->belongsTo(User::class, 'dibuat_oleh_user_id');
}    protected $casts = [
        'tanggal' => 'date',
        'approval_date' => 'datetime'
    ];

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }
    public function creator()
{
    return $this->belongsTo(User::class, 'dibuat_oleh_user_id');
}

}
