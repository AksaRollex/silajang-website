<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class RadiusPengambilan extends Model
{
    use Uuid;
    protected $fillable = ['nama', 'radius', 'harga'];

    public function permohonans()
    {
        return $this->hasMany(Permohonan::class);
    }
}
