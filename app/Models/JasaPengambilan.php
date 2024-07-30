<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class JasaPengambilan extends Model
{
    use Uuid;

    protected $fillable = ['wilayah', 'harga'];

    public function permohonans()
    {
        return $this->hasMany(Permohonan::class);
    }
}
