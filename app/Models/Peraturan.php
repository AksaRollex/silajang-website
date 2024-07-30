<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Peraturan extends Model
{
    use Uuid;

    protected $fillable = ['nama', 'nomor', 'tentang', 'file'];
    protected $appends = ['harga'];

    public function titikPermohonans()
    {
        return $this->hasMany(TitikPermohonan::class);
    }

    public function parameters()
    {
        return $this->belongsToMany(Parameter::class, 'peraturan_parameters')->withPivot('baku_mutu', 'cetak_miring');
    }

    public function isHasParameter($parameter_id)
    {
        return $this->parameters()->where('parameters.id', $parameter_id)->exists();
    }

    public function getHargaAttribute()
    {
        return $this->parameters()->sum('harga');
    }
}
