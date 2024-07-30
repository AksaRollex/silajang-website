<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class UmpanBalik extends Model
{
    use Uuid;
    protected $fillable = [
        'nomer', 'tahun', 'bulan',
        'u1', 'keterangan_u1',
        'u2', 'keterangan_u2',
        'u3', 'keterangan_u3',
        'u4', 'keterangan_u4',
        'u5', 'keterangan_u5',
        'u6', 'keterangan_u6',
        'u7', 'keterangan_u7',
        'u8', 'keterangan_u8',
        'u9', 'keterangan_u9',
        // 'u10', 'keterangan_u10',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
