<?php

// app/Models/MemoLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemoLog extends Model
{
    protected $fillable = [
        'memo_id', 'divisi', 'aksi', 'catatan', 'user_id', 'waktu'
    ];

    public $timestamps = false;

    public function memo()
    {
        return $this->belongsTo(Memo::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

