<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Divisi extends Model
{
    use HasFactory;
    
    protected $fillable = ['nama', 'urutan'];

    public function getRoutePrefixAttribute()
    {
        $nama = strtolower(str_replace(' ', '', $this->nama));
        
        // Handle khusus untuk "Pengembangan Bisnis"
        if ($nama === 'pengembanganbisnis') {
            return 'pengembangan';
        }
        if ($nama === 'marketingdansales') {
            return 'marketing';
        }
        if ($nama === 'operasionalwilayahi') {
            return 'opwil1';
        }
        if ($nama === 'foodbeverage') {
            return 'food';
        }
        if ($nama === 'infrastrukturdansipil') {
            return 'sipil';
        }
        if ($nama === 'administrasidankeuangan') {
            return 'adminkeu';
        }
        if ($nama === 'umumdanlegal') {
            return 'umumlegal';
        }
        if ($nama === 'operasionalwilayahii') {
            return 'opwil2';
        }
        
        return $nama;
    }

    public function asistenManagers()
    {
        return $this->hasMany(User::class)
            ->where('role', 'asisten_manager')
            ->where('active', true);
    }

    // PERBAIKAN: Tambahkan relasi memos() yang sesuai dengan struktur database
    public function memosAsTujuan()
    {
        // Relasi ke memo berdasarkan divisi_tujuan (nama divisi)
        return $this->hasMany(Memo::class, 'divisi_tujuan', 'nama');
    }

    public function memosAsDari()
    {
        // Relasi ke memo berdasarkan dari (nama divisi)
        return $this->hasMany(Memo::class, 'dari', 'nama');
    }

    // Relasi gabungan untuk mendapatkan semua memo terkait divisi ini
    public function memos()
    {
        // Karena kolom di memo adalah string nama divisi, kita gunkan cara ini
        return Memo::where('divisi_tujuan', $this->nama)
            ->orWhere('dari', $this->nama);
    }

    // Accessor untuk mendapatkan jumlah memo
    public function getMemoCountAttribute()
    {
        return $this->memos()->count();
    }

    // Accessor untuk memo disetujui
    public function getApprovedCountAttribute()
    {
        return $this->memos()->where('status', 'disetujui')->count();
    }

    // Accessor untuk memo ditolak
    public function getRejectedCountAttribute()
    {
        return $this->memos()->where('status', 'ditolak')->count();
    }

    // Accessor untuk memo pending
    public function getPendingCountAttribute()
    {
        return $this->memos()->where('status', 'diajukan')->count();
    }

    // Relasi ke users (staff)
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Scope untuk divisi aktif yang memiliki memo
    public function scopeActiveWithMemos($query)
    {
        return $query->whereIn('nama', function($subquery) {
            $subquery->select('divisi_tujuan')
                ->from('memos')
                ->distinct();
        });
    }
}