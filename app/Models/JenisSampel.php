<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class JenisSampel extends Model
{
    use Uuid;
    protected $fillable = ['nama', 'kode'];

    public function titikPermohonans()
    {
        return $this->hasMany(TitikPermohonan::class);
    }
}
