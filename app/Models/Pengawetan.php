<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Pengawetan extends Model
{
    use Uuid;
    protected $fillable = ['nama'];

    public function parameters()
    {
        return $this->belongsToMany(Parameter::class, 'pengawetan_parameters');
    }
}
