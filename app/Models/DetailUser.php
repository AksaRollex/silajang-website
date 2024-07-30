<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class DetailUser extends Model
{
    use Uuid;

    protected $fillable = ['user_id', 'tanda_tangan', 'instansi', 'alamat', 'pimpinan', 'pj_mutu', 'telepon', 'fax', 'email', 'jenis_kegiatan', 'lat', 'long', 'kab_kota_id', 'kecamatan_id', 'kelurahan_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kab_kota()
    {
        return $this->belongsTo(KabKota::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }
}
