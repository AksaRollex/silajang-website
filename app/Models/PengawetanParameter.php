<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class PengawetanParameter extends Model
{
    use Uuid;
    protected $fillable = ['pengawetan_id', 'parameter_id'];

    public function pengawetan()
    {
        return $this->belongsTo(Pengawetan::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
