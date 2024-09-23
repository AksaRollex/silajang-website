<?php

namespace App\Models;

use App\Helpers\AppHelper;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Permohonan extends Model {
  use Uuid;

  protected  $fillable = ['keterangan', 'industri', 'kegiatan', 'alamat', 'pembayaran', 'is_mandiri', 'user_id', 'jasa_pengambilan_id', 'jenis_contoh_id', 'kesimpulan_kontrak', 'kontrak_id'];
  protected $appends = ['tanggal', 'editable'];

  public function user() {
    return $this->belongsTo(User::class);
  }

  public function kontrak() {
    return $this->belongsTo(Kontrak::class);
  }

  public function jasaPengambilan() {
    return $this->belongsTo(JasaPengambilan::class);
  }

  // public function jenisContoh() {
  //   return $this->belongsTo(JenisContoh::class);
  // }

  public function titikPermohonans() {
    return $this->hasMany(TitikPermohonan::class);
  }

  public function radiusPengambilan() {
    return $this->belongsTo(RadiusPengambilan::class);
  }

  public function getTanggalAttribute() {
    return AppHelper::tanggal_indo(Carbon::parse($this->created_at)->format('Y-m-d'));
  }

  public function getEditableAttribute() {
    $status = $this->titikPermohonans->pluck('status')->toArray();
    $editable = true;

    foreach ($status as $s) {
      if ($s > 2) {
        $editable = false;
      }
    }

    return $editable;
  }

  /**
   * Calculates the great-circle distance between two points, with
   * the Vincenty formula.
   * @param float $latitudeFrom Latitude of start point in [deg decimal]
   * @param float $longitudeFrom Longitude of start point in [deg decimal]
   * @param float $latitudeTo Latitude of target point in [deg decimal]
   * @param float $longitudeTo Longitude of target point in [deg decimal]
   * @param float $earthRadius Mean earth radius in [m]
   * @return float Distance between points in [m] (same as earthRadius)
   */
  public static function vincentyGreatCircleDistance(
    $latitudeFrom,
    $longitudeFrom,
    $latitudeTo,
    $longitudeTo,
    $earthRadius = 6371000
  ) {
    // convert from degrees to radians
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $lonDelta = $lonTo - $lonFrom;
    $a = pow(cos($latTo) * sin($lonDelta), 2) +
      pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
    $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

    $angle = atan2(sqrt($a), $b);
    return $angle * $earthRadius;
  }
}
