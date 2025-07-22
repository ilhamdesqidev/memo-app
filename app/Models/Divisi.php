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
}
