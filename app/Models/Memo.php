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
        'lampiran',
        'isi',
        'signature_path', // Assuming you want to store the path of the signature image
    ];

    // Optionally, you can define relationships or other model methods here
}
