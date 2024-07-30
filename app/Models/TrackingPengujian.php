<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class TrackingPengujian extends Model
{
    use Uuid;
    protected $fillable = ['titik_permohonan_id', 'status', 'keterangan'];

    public function titik()
    {
        return $this->belongsTo(TitikPermohonan::class);
    }
}
