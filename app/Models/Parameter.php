<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    use Uuid;

    protected $fillable = ['nama', 'keterangan', 'metode', 'harga', 'satuan', 'mdl', 'is_akreditasi', 'is_dapat_diuji', 'jenis_parameter_id'];
    protected $with = ['jenisParameter'];

    public function jenisParameter()
    {
        return $this->belongsTo(JenisParameter::class);
    }

    public function peraturans()
    {
        return $this->belongsToMany(Peraturan::class, 'peraturan_parameters')->withPivot('baku_mutu', 'cetak_miring');
    }

    public function titikPermohonans()
    {
        return $this->belongsToMany(TitikPermohonan::class, 'titik_permohonan_parameters')->withPivot('harga', 'satuan', 'mdl', 'kuantitas');
    }

    public function pengawetans()
    {
        return $this->belongsToMany(Pengawetan::class, 'pengawetan_parameters');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_parameters');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_parameters');
    }

    public function pakets()
    {
        return $this->belongsToMany(Paket::class, 'paket_parameters');
    }

    public function isHasPeraturan($peraturan_id)
    {
        return $this->peraturans()->where('peraturans.id', $peraturan_id)->exists();
    }
}
