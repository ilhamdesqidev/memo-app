<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Memo extends Model
{
    use HasFactory;

    const STATUS_DIAJUKAN = 'diajukan';
    const STATUS_DISETUJUI = 'disetujui';
    const STATUS_DITOLAK = 'ditolak';
    const STATUS_REVISI = 'revisi';

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
        'pdf_path',
        'tembusan'
    ];

    protected $casts = [
        'tanggal' => 'datetime:Y-m-d',
        'approval_date' => 'datetime',
        'signed_at' => 'datetime',
        'tembusan' => 'array'
    ];

    protected $appends = ['has_signature'];

    public static function getStatuses()
    {
        return [
            self::STATUS_DIAJUKAN => 'Diajukan',
            self::STATUS_DISETUJUI => 'Disetujui',
            self::STATUS_DITOLAK => 'Ditolak',
            self::STATUS_REVISI => 'Revisi'
        ];
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

    public function divisiAsal()
    {
        return $this->belongsTo(Divisi::class, 'dari', 'nama');
    }

    public function divisiTujuan()
    {
        return $this->belongsTo(Divisi::class, 'divisi_tujuan', 'nama');
    }

    public function logs()
    {
        return $this->hasMany(MemoLog::class);
    }

    public function getHasSignatureAttribute()
    {
        return !empty($this->signature_path) && Storage::exists($this->signature_path);
    }
    public function getFormattedTanggalAttribute()
{
    try {
        return $this->tanggal->format('d M Y');
    } catch (\Exception $e) {
        return '.........................';
    }
}
}