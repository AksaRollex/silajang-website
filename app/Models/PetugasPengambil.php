<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class PetugasPengambil extends Model
{
    use Uuid;
    protected $fillable = ['petugas_id', 'titik_permohonan_id'];

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function titik_permohonan()
    {
        return $this->belongsTo(TitikPermohonan::class);
    }
}
