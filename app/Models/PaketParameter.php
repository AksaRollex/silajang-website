<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class PaketParameter extends Model
{
    use Uuid;
    protected $fillable = ['paket_id', 'parameter_id'];

    public function paket()
    {
        return $this->belongsTo(Paket::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}
