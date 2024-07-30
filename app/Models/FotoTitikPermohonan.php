<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class FotoTitikPermohonan extends Model
{
    use Uuid;
    protected $fillable = ['titik_permohonan_id', 'foto', 'keterangan'];

    public function titikPermohonan()
    {
        return $this->belongsTo(TitikPermohonan::class);
    }

    protected static function booted()
    {
        static::deleted(function ($foto) {
            if ($foto->foto != null && $foto->foto != '') {
                $old_photo = str_replace('/storage/', '', $foto->foto);
                Storage::disk('public')->delete($old_photo);
            }
        });
    }
}
