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
        'tembusan',
        'manager_signed',
        'approval_notes',
        'signature_path',
        'creator_signed_at',
        'manager_signature_path',
        'manager_signed_at',
        'forwarded_by',
        'forwarded_at',
        'rejected_by',
        'rejection_date'
    ];

    protected $casts = [
        'tanggal' => 'datetime:Y-m-d',
        'approval_date' => 'datetime',
        'signed_at' => 'datetime',
        'creator_signed_at' => 'datetime',
        'manager_signed_at' => 'datetime',
        'forwarded_at' => 'datetime',
        'rejection_date' => 'datetime',
        'tembusan' => 'array',
        'manager_signed' => 'boolean'
    ];

    protected $appends = ['has_signature', 'has_creator_signature', 'has_manager_signature'];

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

    public function diteruskanOleh()
    {
        return $this->belongsTo(User::class, 'forwarded_by');
    }

    public function ditolakOleh()
    {
        return $this->belongsTo(User::class, 'rejected_by');
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

    // Accessors
    public function getHasSignatureAttribute()
    {
        return !empty($this->signature_path) && Storage::exists('public/' . $this->signature_path);
    }

    public function getHasCreatorSignatureAttribute()
    {
        return !empty($this->signature_path) && Storage::exists('public/' . $this->signature_path);
    }

    public function getHasManagerSignatureAttribute()
    {
        return !empty($this->manager_signature_path) && Storage::exists('public/' . $this->manager_signature_path);
    }

    public function getFormattedTanggalAttribute()
    {
        try {
            return $this->tanggal->format('d M Y');
        } catch (\Exception $e) {
            return '.........................';
        }
    }

    // Helper methods
    public function hasDualSignature()
    {
        return $this->has_creator_signature && $this->has_manager_signature;
    }

    public function getCreatorSignatureInfo()
    {
        if ($this->dibuatOleh && $this->has_creator_signature) {
            return [
                'name' => $this->dibuatOleh->name,
                'position' => $this->dibuatOleh->role === 'asisten_manager' ? 'Asisten Manager' : 'Staff',
                'division' => $this->dibuatOleh->divisi->nama ?? $this->dari,
                'signature_path' => $this->signature_path,
                'signed_at' => $this->creator_signed_at
            ];
        }
        return null;
    }

    public function getManagerSignatureInfo()
    {
        if ($this->has_manager_signature) {
            $manager = null;
            
            // Try to get manager from forwarded_by or signed_by
            if ($this->forwarded_by) {
                $manager = User::find($this->forwarded_by);
            } elseif ($this->signed_by) {
                $manager = User::find($this->signed_by);
            }

            if ($manager && $manager->role === 'manager') {
                return [
                    'name' => $manager->name,
                    'position' => 'Manager',
                    'division' => 'Manager',
                    'signature_path' => $this->manager_signature_path,
                    'signed_at' => $this->manager_signed_at
                ];
            }
        }
        return null;
    }

    public function isFullySigned()
    {
        // Memo dianggap fully signed jika sudah ada tanda tangan pembuat dan manager (jika diperlukan)
        if ($this->status === self::STATUS_DISETUJUI) {
            return $this->has_creator_signature || $this->has_manager_signature || $this->has_signature;
        }
        return false;
    }

    public function forwardedBy()
    {
        return $this->belongsTo(User::class, 'forwarded_by');
    }
}