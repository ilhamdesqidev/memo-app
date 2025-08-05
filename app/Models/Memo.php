<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor',
        'tanggal',
        'kepada',
        'dari',
        'perihal',
        'isi',
        'lampiran',
        'divisi_tujuan',
        'status',
        'dibuat_oleh_user_id',
        'approved_by',
        'approval_date',
        'include_signature',
        'signature_path',
        'signed_by',
        'signed_at',
        'pdf_path'
    ];

    protected $casts = [
        'tanggal' => 'datetime:Y-m-d',
        'approval_date' => 'datetime',
        'signed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function divisiAsal()
    {
        return $this->belongsTo(Divisi::class, 'dari', 'nama');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh_user_id');
    }

    public function logs()
    {
        return $this->hasMany(MemoLog::class);
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh_user_id');
    }

    public function disetujuiOleh()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function ditandatanganiOleh()
    {
        return $this->belongsTo(User::class, 'signed_by');
    }
}