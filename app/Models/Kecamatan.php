<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use Uuid;
    protected $fillable = ['kab_kota_id', 'nama'];

    public function kab_kota()
    {
        return $this->belongsTo(KabKota::class);
    }

    public function kelurahans()
    {
        return $this->hasMany(Kelurahan::class);
    }
}
