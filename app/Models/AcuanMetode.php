<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class AcuanMetode extends Model
{
    use Uuid;
    protected $fillable = ['nama'];

    public function titikPermohonans()
    {
        return $this->hasMany(TitikPermohonan::class);
    }
}
