<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    use Uuid;
    protected $fillable = ['nama', 'kecamatan_id', 'kab_kota_id'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kab_kota()
    {
        return $this->belongsTo(KabKota::class);
    }
}
