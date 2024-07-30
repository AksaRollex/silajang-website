<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class TitikPermohonanJenisWadah extends Model
{
    use Uuid;
    protected $fillable = ['titik_permohonan_id', 'jenis_wadah_id'];

    public function titikPermohonan()
    {
        return $this->belongsTo(TitikPermohonan::class);
    }

    public function jenisWadah()
    {
        return $this->belongsTo(JenisWadah::class);
    }
}
