<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Payment extends Model {
  use Uuid;
  protected $fillable = [
    'type',

    'kode',
    'va_number',
    'nama',
    'jumlah',
    'tanggal_exp',
    'is_lunas',
    'status',
    'tanggal_bayar',
    'titik_permohonan_id',
    'kode_retribusi_id',
    'berita1',
    'berita2',
    'berita3',
    'berita4',
    'berita5',

    'qris_value',
    'qris_number',
    'qris_expired'
  ];
  protected $appends = ['is_expired'];
  protected $with = ['kodeRetribusi'];

  public function multiPayments() {
    return $this->hasMany(MultiPayment::class);
  }

  public function titikPermohonan() {
    return $this->belongsTo(TitikPermohonan::class);
  }

  public function kodeRetribusi() {
    return $this->belongsTo(KodeRetribusi::class);
  }

  public function getIsExpiredAttribute() {
    if ($this->is_lunas || $this->status == 'success') return false;
    return Carbon::parse($this->tanggal_exp)->endOfDay() < now();
  }

  public function genKode() {
    /*
            Format: 0001/01/SKR-LAB/DLH/2024
            00001: Nomor urut berdasarkan tahun (4 digit)
            01: Kode Retribusi
            SKR-LAB/DLH = Kode fix
            2024: Tahun
        */
    $tahun = Carbon::parse($this->created_at)->format('Y');
    $payment = Payment::whereYear('created_at', $tahun)->where('kode', '!=', NULL)->orderBy('kode', 'DESC')->first();
    $retribusi = $this->kodeRetribusi()->first();

    if ($payment == null) {
      $last_kode = 1;
    } else {
      $last_kode = explode('/', $payment->kode);
      $last_kode = (int)$last_kode[0];
      $last_kode = $last_kode + 1;
    }
    $last_kode = str_pad($last_kode, 4, '0', STR_PAD_LEFT);

    if (!$this->kode) {
      $this->kode = "$last_kode/$retribusi->kode/SKR-LAB/DLH/$tahun";
      $this->save();
    }
  }
}
