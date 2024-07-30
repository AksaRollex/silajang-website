<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class TitikPermohonanLapangan extends Model
{
    use Uuid;
    protected $fillable = [
        'titik_permohonan_id',
        'suhu_air',
        'ph',
        'dhl',
        'salinitas',
        'do',
        'kekeruhan',
        'klorin_bebas',

        'suhu_udara',
        'arah_angin',
        'kelembapan',
        'kecepatan_angin',
        'cuaca'
    ];

    public function titikPermohonan()
    {
        return $this->belongsTo(TitikPermohonan::class);
    }

    protected static function booted()
    {
        static::created(function ($data) {
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'Suhu');
            })->update(['hasil_uji' => $data->suhu_air]);
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'pH');
            })->update(['hasil_uji' => $data->ph]);
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'DHL');
            })->update(['hasil_uji' => $data->dhl]);
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'Salinitas');
            })->update(['hasil_uji' => $data->salinitas]);
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'DO');
            })->update(['hasil_uji' => $data->do]);
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'Kekeruhan');
            })->update(['hasil_uji' => $data->kekeruhan]);
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'Klorin Bebas');
            })->update(['hasil_uji' => $data->klorin_bebas]);
        });

        static::updated(function ($data) {
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'Suhu');
            })->update(['hasil_uji' => $data->suhu_air]);
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'pH');
            })->update(['hasil_uji' => $data->ph]);
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'DHL');
            })->update(['hasil_uji' => $data->dhl]);
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'Salinitas');
            })->update(['hasil_uji' => $data->salinitas]);
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'DO');
            })->update(['hasil_uji' => $data->do]);
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'Kekeruhan');
            })->update(['hasil_uji' => $data->kekeruhan]);
            TitikPermohonanParameter::where('titik_permohonan_id', $data->titik_permohonan_id)->whereHas('parameter', function ($q) {
                $q->where('nama', 'LIKE', 'Klorin Bebas');
            })->update(['hasil_uji' => $data->klorin_bebas]);
        });
    }
}
