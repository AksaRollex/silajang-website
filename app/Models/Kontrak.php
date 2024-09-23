<?php

namespace App\Models;

use App\Helpers\AppHelper;
use App\Traits\Uuid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model {
  use Uuid;

  protected $fillable = [
    'nomor_surat',
    'dokumen_permohonan',
    'perihal',
    'tanggal_surat',
    'bulan',
  ];

  protected $appends = ['tanggal'];

  protected $casts = [
    'bulan' => 'array',
  ];

  public function permohonan() {
    return $this->hasOne(Permohonan::class);
  }

  public function getTanggalAttribute() {
    return AppHelper::tanggal_indo(Carbon::parse($this->tanggal_surat)->format('Y-m-d'));
  }
}
