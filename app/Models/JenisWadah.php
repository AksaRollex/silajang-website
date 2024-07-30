<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class JenisWadah extends Model
{
    use Uuid;
    protected $fillable = [
        'nama',
        'keterangan',
    ];

    public function permohonans()
    {
        return $this->hasMany(Permohonan::class);
    }
}
