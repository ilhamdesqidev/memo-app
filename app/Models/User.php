<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
   protected $fillable = [
    'name',
    'username', // Tambahkan username
    'email',
    'password',
    'role',
    'divisi_id',
    'jabatan',
    'signature',
];
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    

    public function isAdmin()
{
    return $this->role === 'admin';
}

public function divisi()
{
    return $this->belongsTo(Divisi::class)->withDefault([
        'nama' => 'TIDAK ADA DIVISI'
    ]);
} 

// Atau lebih aman:
public function getDivisiNameAttribute()
{
    return $this->divisi ? $this->divisi->nama : null;
}
}
