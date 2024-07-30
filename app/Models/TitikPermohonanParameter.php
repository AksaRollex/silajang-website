<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class TitikPermohonanParameter extends Model
{
    use Uuid;

    // protected $fillable = ['titik_permohonan_id', 'parameter_id', 'harga', 'satuan', 'baku_mutu', 'mdl', 'hasil_uji', 'keterangan', 'kuantitas', 'acc_analis', 'acc_manager', 'acc_upt', 'acc_analis_at', 'acc_manager_at', 'acc_upt_at'];
    protected $fillable = [
        'titik_permohonan_id',
        'parameter_id',
        'harga',
        'satuan',
        'baku_mutu',
        'mdl',
        'hasil_uji',
        'hasil_uji_pembulatan',
        'keterangan',
        'keterangan_hasil',
        'kuantitas',
        'acc_analis',
        'acc_manager',
        'acc_upt',
        'acc_analis_at',
        'acc_manager_at',
        'acc_upt_at',
        'personel',
        'metode',
        'peralatan',
        'reagen',
        'akomodasi',
        'beban_kerja',
    ];

    public function titikPermohonan()
    {
        return $this->belongsTo(TitikPermohonan::class);
    }

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }

    public static function getHasil($data)
    {
        $baku_mutu = $data->baku_mutu;
        $parameter = Parameter::find($data->parameter_id);
        if (strpos($baku_mutu, '<') !== false) {
            $baku_mutu = str_replace('<', '', $baku_mutu);
        }

        if (preg_match("/^\d*\.?\d*$/", $baku_mutu)) {
            $baku_mutu = (float) $baku_mutu;
        } elseif (str_contains($baku_mutu, '-')) {
            $baku_mutu = explode('-', $baku_mutu);
        } else {
            $baku_mutu = (float) str_replace(',', '.', $baku_mutu);
        }

        $hasil_uji = $data->hasil_uji_pembulatan;
        if (strpos($hasil_uji, '<') !== false) {
            $hasil_uji = str_replace('<', '', $hasil_uji);
        }

        if (preg_match("/^\d*\.?\d*$/", $hasil_uji)) {
            $hasil_uji = (float) $hasil_uji;
        } else {
            $hasil_uji = (float) str_replace(',', '.', $hasil_uji);
        }

        if (isset($data->keterangan_hasil)) {
            return $data->keterangan_hasil;
        }

        $keterangan = 'Memenuhi';
        if ($data->baku_mutu != '-' && isset($data->baku_mutu)) {
            if (gettype($baku_mutu) == 'array') {
                if (str_contains($parameter->nama, 'DO') && $hasil_uji < $baku_mutu[0]) {
                    $keterangan = 'Di Luar Baku Mutu';
                } elseif (!str_contains($parameter->nama, 'DO') && ($baku_mutu[0] > $hasil_uji || $baku_mutu[1] < $hasil_uji)) {
                    $keterangan = 'Tidak Memenuhi';
                }
            } else {
                if (str_contains($parameter->nama, 'DO') && $hasil_uji < $baku_mutu) {
                    $keterangan = 'Di Luar Baku Mutu';
                } elseif (!str_contains($parameter->nama, 'DO') && isset($data->baku_mutu) && $data->baku_mutu != '-' && $baku_mutu < $hasil_uji) {
                    $keterangan = 'Tidak Memenuhi';
                }
            }
        }

        return $keterangan;
    }
}
