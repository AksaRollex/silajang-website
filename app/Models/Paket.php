<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use Uuid;
    protected $fillable = ['nama', 'harga'];

    public function parameters()
    {
        return $this->belongsToMany(Parameter::class, 'paket_parameters');
    }
}
