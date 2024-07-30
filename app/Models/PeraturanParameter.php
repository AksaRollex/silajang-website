<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class PeraturanParameter extends Model
{
    use Uuid;

    protected $fillable = ['peraturan_id', 'parameter_id', 'baku_mutu', 'cetak_miring'];

    public function peraturan()
    {
        return $this->belongsTo(Peraturan::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
