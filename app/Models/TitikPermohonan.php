<?php

namespace App\Models;

use App\Helpers\AppHelper;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\ReportController;
use App\Services\WhatsApp;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class TitikPermohonan extends Model {
  use Uuid;

  protected $fillable = [
    'kode',
    'no_lhu',
    'no_formulir',
    'lokasi',
    'south',
    'east',
    'keterangan',
    'permohonan_id',
    'jenis_sampel_id',
    'jenis_wadah_id',
    'peraturan_id',
    'pengambil_id',
    'nama_pengambil',
    'tanggal_pengambilan',
    'status',
    'keterangan_revisi',
    'status_pembayaran',
    'sertifikat',
    'tanggal_diterima',
    'tanggal_selesai',
    'tanggal_tte',
    'acuan_metode_id',
    'baku_mutu',
    'hasil_pengujian',
    'memenuhi_hasil_pengujian',
    'kesimpulan_permohonan',
    'lab_subkontrak',
    'kesimpulan_sampel',
    'kondisi_sampel',
    'keterangan_kondisi_sampel',
    'pengawetan_oleh',
    'radius_pengambilan_id',
    'obyek_pelayanan',
    'file_lhu',
    'save_parameter',
    'user_has_va',
    'can_upload',
    'verifikasi_lhu',

    'status_tte', // LHU
    'status_tte_skrd',
    'status_tte_kwitansi',
    'status_tte_kendali_mutu',

    'payment_type'
  ];
  protected $appends = ['pakets', 'tanggal', 'text_status', 'text_status_pembayaran', 'harga', 'is_has_subkontrak', 'tanggal_mulai_uji', 'tanggal_selesai_uji', 'jam_datang_uji', 'pengambil', 'jenis_wadahs_id', 'tte_lhu', 'tte_skrd', 'tte_kwitansi', 'tte_kendali_mutu'];
  protected $with = ['jenisSampel', 'jenisWadah', 'jenisWadahs', 'parameters', 'peraturan', 'lapangan'];

  public function permohonan() {
    return $this->belongsTo(Permohonan::class);
  }

  // public function pengambil()
  // {
  //     return $this->belongsTo(User::class);
  // }

  public function logTtes() {
    return $this->hasMany(LogTTE::class);
  }

  public function petugasPengambils() {
    return $this->belongsToMany(User::class, 'petugas_pengambils', 'titik_permohonan_id', 'petugas_id');
  }

  public function getPengambilAttribute() {
    return $this->petugasPengambils()->first();
  }

  public function peraturan() {
    return $this->belongsTo(Peraturan::class);
  }

  public function acuanMetode() {
    return $this->belongsTo(AcuanMetode::class);
  }

  public function lapangan() {
    return $this->hasOne(TitikPermohonanLapangan::class);
  }

  public function parameters() {
    return $this->belongsToMany(Parameter::class, 'titik_permohonan_parameters')
      ->withPivot(
        'created_at',
        'updated_at',
        'harga',
        'satuan',
        'baku_mutu',
        'mdl',
        'hasil_uji',
        'hasil_uji_pembulatan',
        'keterangan',
        'kuantitas',
        'acc_analis',
        'acc_manager',
        'acc_analis_at',
        'acc_manager_at',
        'personel',
        'metode',
        'peralatan',
        'reagen',
        'akomodasi',
        'beban_kerja',
        'keterangan_hasil',
      );
  }

  public function payment() {
    return $this->hasOne(Payment::class)->where('status', '!=', 'failed')->orderBy('created_at', 'DESC');
  }

  public function photos() {
    return $this->hasMany(FotoTitikPermohonan::class);
  }

  public function getParamsByUser($orderBy = null, $roles = ['admin', 'kepala-upt', 'koordinator-administrasi', 'koordinator-teknis']) {
    if (auth()->user()->hasRole($roles)) {
      return $this->parameters()->orderByPivot($orderBy ?? 'id')->get();
    }

    $allowedParams = auth()->user()->parameters()->pluck('parameters.id')->toArray();
    $params = $this->parameters()->whereIn('parameter_id', $allowedParams)->get();
    return $params;
  }

  public function jenisSampel() {
    return $this->belongsTo(JenisSampel::class);
  }

  public function jenisWadah() {
    return $this->belongsTo(JenisWadah::class);
  }

  public function jenisWadahs() {
    return $this->belongsToMany(JenisWadah::class, 'titik_permohonan_jenis_wadahs');
  }

  public function trackings() {
    return $this->hasMany(TrackingPengujian::class)->orderBy('id', 'desc');
  }

  public function getTteLhuAttribute() {
    $filename = 'LAPORAN-HASIL-PENGUJIAN-' . str_replace('/', '_', $this->kode) . '.pdf';

    if (file_exists(storage_path('app/private/lhu/' . $filename))) {
      return storage_path('app/private/lhu/' . $filename);
    }

    return null;
  }

  public function getTteSkrdAttribute() {
    $filename = 'SKRD-' . str_replace('/', '_', $this->kode) . '.pdf';

    if (file_exists(storage_path('app/private/skrd/' . $filename))) {
      return storage_path('app/private/skrd/' . $filename);
    }

    return null;
  }

  public function getTteKwitansiAttribute() {
    $filename = 'Kwitansi-' . str_replace('/', '_', $this->kode) . '.pdf';

    if (file_exists(storage_path('app/private/kwitansi/' . $filename))) {
      return storage_path('app/private/kwitansi/' . $filename);
    }

    return null;
  }

  public function getTteKendaliMutuAttribute() {
    $filename = 'Kendali-Mutu-' . str_replace('/', '_', $this->no_formulir) . '.pdf';

    if (file_exists(storage_path('app/private/kendali-mutu/' . $filename))) {
      return storage_path('app/private/kendali-mutu/' . $filename);
    }

    return null;
  }

  public function getTanggalAttribute() {
    return AppHelper::tanggal_indo(Carbon::parse($this->created_at)->format('Y-m-d'));
  }

  public function getTextStatusAttribute() {
    $status = [
      -1 => "Revisi",
      0 => "Mengajukan Permohonan",
      1 => "Menyerahkan Sampel",
      2 => "Menyerahkan Surat Perintah Pengujian",
      3 => "Menyerahkan sampel untuk Proses Pengujian",
      4 => "Menyerahkan RDPS",
      5 => "Menyerahkan RDPS untuk Pengetikan LHU",
      6 => "Menyerahkan LHU untuk Diverifikasi",
      7 => "Mengesahkan LHU",
      8 => "Pembayaran",
      9 => "Penyerahan LHU",
      10 => "Penyerahan LHU Amandemen (Jika ada)",
      11 => "Selesai",
    ];

    return @$status[$this->status] ?? "Sedang Diproses";
  }

  public function getTextStatusPembayaranAttribute() {
    $status = [
      0 => "Belum Dibayar",
      1 => "Berhasil",
      2 => "Gagal",
    ];

    return @$status[$this->status_pembayaran] ?? "Belum Dibayar";
  }

  public function getPaketsAttribute() {
    $parameters = $this->parameters()->get()->pluck('id');
    $pakets = Paket::with(['parameters'])->get();
    return $pakets->filter(function ($paket) use ($parameters) {
      if (!count($paket->parameters)) return false;

      return $paket->parameters->every(function ($param) use ($parameters) {
        $check = $parameters->first(function ($a) use ($param) {
          return $a == $param->id;
        });
        return isset($check);
      });
    })->values();
  }

  public function getHargaAttribute() {
    $pakets = $this->getPaketsAttribute();
    $parameters = $pakets->pluck('parameters')->flatten()->pluck('id');

    $harga = $pakets->sum('harga');
    return $harga + $this->parameters()->where('is_dapat_diuji', 1)->whereNotIn('parameters.id', $parameters)->sum('titik_permohonan_parameters.harga');
  }

  public function getIsHasSubkontrakAttribute() {
    return $this->parameters()->where('is_dapat_diuji', 0)->count() > 0;
  }

  public function getJenisWadahsIdAttribute() {
    return $this->jenisWadahs()->pluck('jenis_wadahs.id')->toArray();
  }

  public function genKode() {
    /*
            Format: KJB-2306-022
            KJB = Kode fix
            2306 = Tanggal (yymm)
            022 = Nomor urut permohonan berdasarkan bulan (3 digit)
        */
    $tahun = Carbon::parse($this->tanggal_diterima)->format('Y');
    $bulan = Carbon::parse($this->tanggal_diterima)->format('m');
    $titik = TitikPermohonan::whereMonth('tanggal_diterima', $bulan)->whereYear('tanggal_diterima', $tahun)->where('kode', '!=', '(Belum Ditetapkan)')->orderBy('kode', 'DESC')->first();

    $tahun = Carbon::parse($this->tanggal_diterima)->format('y');
    if ($titik == null) {
      $last_kode = 1;
    } else {
      $last_kode = explode('/', $titik->kode);
      $last_kode = $last_kode[0];
      $last_kode = explode('-', $last_kode);
      $last_kode = $last_kode[2];
      $last_kode = $last_kode + 1;
    }
    $last_kode = str_pad($last_kode, 3, '0', STR_PAD_LEFT);

    if ($this->kode == '(Belum Ditetapkan)') {
      $this->kode = "KJB-$tahun$bulan-$last_kode";
      $this->save();
    }
  }

  public function genNoLhu() {
    /*
            Format: 371/AL/415.34.1/VI/2023
            371 = nomor urut per tahun
            AL = jenis sampel (Air Limbah => AL)
            415.34.1 = kode instansi (fix)
            VI = bulan romawi
            2023 = tahun
        */
    $jenis_sampel = JenisSampel::find($this->jenis_sampel_id);
    $jenis_sampel = $jenis_sampel->kode;

    $last_no_lhu = TitikPermohonan::whereYear('created_at', date('Y'))->where('no_lhu', '!=', '(Belum Ditetapkan)')->orderBy('no_lhu', 'DESC')->first();

    if ($last_no_lhu == null) {
      $last_no_lhu = 1;
    } else {
      $last_no_lhu = explode('/', $last_no_lhu->no_lhu);
      $last_no_lhu = $last_no_lhu[0];
      $last_no_lhu = $last_no_lhu + 1;
    }
    $last_no_lhu = str_pad($last_no_lhu, 3, '0', STR_PAD_LEFT);

    $instansi = '415.34.1';

    $bulan_romawi = AppHelper::BulanToRomawi((int)date('m'));

    $tahun = date('Y');

    if ($this->no_lhu == '(Belum Ditetapkan)') {
      $this->no_lhu = $last_no_lhu . '/' . $jenis_sampel . '/' . $instansi . '/' . $bulan_romawi . '/' . $tahun;
      $this->save();
    }
  }

  public function genNoFormulir() {
    /*
            Format: 123/SPP/I/2023
            371 = nomor urut per tahun
            SPP = kode (fix)
            I = bulan romawi
            2023 = tahun
        */
    $last_no_formulir = TitikPermohonan::whereYear('created_at', date('Y'))->where('no_formulir', '!=', '(Belum Ditetapkan)')->orderBy('no_formulir', 'DESC')->first();

    if ($last_no_formulir == null) {
      $last_no_formulir = 1;
    } else {
      $last_no_formulir = explode('/', $last_no_formulir->no_formulir);
      $last_no_formulir = $last_no_formulir[0];
      $last_no_formulir = $last_no_formulir + 1;
    }

    $last_no_formulir = str_pad($last_no_formulir, 3, '0', STR_PAD_LEFT);

    $kode = 'SPP';

    $bulan_romawi = AppHelper::BulanToRomawi((int)date('m'));

    $tahun = date('Y');

    if ($this->no_formulir == '(Belum Ditetapkan)') {
      $this->no_formulir = $last_no_formulir . '/' . $kode . '/' . $bulan_romawi . '/' . $tahun;
      $this->save();
    }
  }

  public function checkAnalis() {
    $currentStatus = $this->status;

    // Check if all parameters are filled
    // If yes, update status to 5
    $allFilled = true;
    foreach ($this->parameters()->where('is_dapat_diuji', 1)->get() as $param) {
      if (!$param->pivot->acc_analis) {
        $allFilled = false;
      }
    }

    if ($allFilled) {
      if ($currentStatus < 5) {
        $this->update(['status' => 5, 'keterangan_revisi' => null]);
        TrackingPengujian::create(['titik_permohonan_id' => $this->id, 'status' => 4]);
        TrackingPengujian::create(['titik_permohonan_id' => $this->id, 'status' => 5]);
      }
    } else {
      if ($currentStatus > 3) {
        $this->update(['status' => 3]);
        TrackingPengujian::create(['titik_permohonan_id' => $this->id, 'status' => $this->status]);
      }
    }
  }

  public function checkManager() // Koordinator Teknis
  {
    $currentStatus = $this->status;

    // Check if all parameters are filled
    // If yes, update status to 7
    $allFilled = true;
    foreach ($this->parameters()->where('is_dapat_diuji', 1)->get() as $param) {
      if (!$param->pivot->acc_manager) {
        $allFilled = false;
      }
    }

    if ($allFilled) {
      if ($currentStatus < 6) {
        $this->update(['status' => 6, 'keterangan_revisi' => null]);
        TrackingPengujian::create(['titik_permohonan_id' => $this->id, 'status' => 6]);
        // TrackingPengujian::create(['titik_permohonan_id' => $this->id, 'status' => 7]);

        $this->genNoLhu();
      }
    } else {
      if ($currentStatus > 5) {
        $this->update(['status' => 5]);
        TrackingPengujian::create(['titik_permohonan_id' => $this->id, 'status' => $this->status]);
      }
    }
  }

  public function getDoneAt() {
    return Carbon::parse(@$this->trackings()->where('status', '9')->orderBy('created_at', 'DESC')->first()->created_at)->format('Y-m-d');
  }

  public function getTanggalMulaiUjiAttribute() {
    $param = $this->parameters()->where('is_dapat_diuji', 1)->where('acc_analis', 1)->orderBy('acc_analis_at', 'ASC')->first();
    if ($param) {
      return $param->pivot->acc_analis_at;
    } else {
      return null;
    }
  }

  public function getTanggalSelesaiUjiAttribute() {
    $param = $this->parameters()->where('is_dapat_diuji', 1)->where('acc_analis', 1)->orderBy('acc_analis_at', 'DESC')->first();
    if ($param) {
      return $param->pivot->acc_analis_at;
    } else {
      return null;
    }
  }

  public function getJamDatangUjiAttribute() {
    $tracking = $this->trackings()->where('status', 3)->orderBy('created_at', 'DESC')->first();
    if ($tracking) {
      return $tracking->created_at->format('H:i');
    } else {
      return null;
    }
  }

  public function check() {
    $check = true;

    foreach ($this->parameters->where('is_dapat_diuji', 1) as $param) {
      $baku_mutu = $param->pivot->baku_mutu;
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

      $hasil_uji = $param->pivot->hasil_uji;
      if (strpos($hasil_uji, '<') !== false) {
        $hasil_uji = str_replace('<', '', $hasil_uji);
      }

      if (preg_match("/^\d*\.?\d*$/", $hasil_uji)) {
        $hasil_uji = (float) $hasil_uji;
      } else {
        $hasil_uji = (float) str_replace(',', '.', $hasil_uji);
      }

      if ($param->pivot->keterangan_hasil == 'Tidak Memenuhi') {
        $check = false;
      }

      if ($param->pivot->baku_mutu != '-' && isset($param->pivot->baku_mutu)) {
        if (gettype($baku_mutu) == 'array') {
          if (str_contains($param->nama, 'DO') && $hasil_uji < $baku_mutu[0]) {
            $check = false;
          }
        } else if (str_contains($param->nama, 'DO') && $hasil_uji < $baku_mutu) {
          $check = false;
        }
      }
    }

    return $check;
  }

  protected static function booted() {
    static::updated(function (TitikPermohonan $titik) {
      if ($titik->status == 3 && $titik->permohonan()->first()->user()->first()->golongan_id == 1 && $titik->status_pembayaran == 0) {
        $pembayaran = new PembayaranController();

        if ($titik->payment_type == "va") {
          $pembayaran->store(request(), $titik->uuid, true);
        } else {
          $pembayaran->storeQr(request(), $titik->uuid, true);
        }
      }

      // if ($titik->status == 9 && $titik->status_pembayaran == 1) {
      //     $wa = new WhatsApp($titik->permohonan()->first()->user()->first()->phone);
      //     $report = new ReportController();
      //     $file = $report->reportLHU(request(), $titik->uuid, true);

      //     $response = $wa->sendFile($file);

      //     if ($response->getStatusCode() == 200 && json_decode($response->getBody())->status) {
      //         $wa->send("#SI-LAJANG*\n\nLaporan Hasil Uji untuk Permohonan Sampel dengan kode " . $titik->kode . "\n\nPassword untuk membuka file adalah nomor WhatsApp Anda.\n\nTerima kasih.");
      //         $titik->update([
      //             'status' => 11,
      //             'sertifikat' => $titik->sertifikat + 1
      //         ]);
      //         TrackingPengujian::create([
      //             'titik_permohonan_id' => $titik->id,
      //             'status' => 11,
      //             'keterangan' => 'Selesai'
      //         ]);
      //     } else {
      //         $wa->send("#SI-LAJANG*\n\nLaporan Hasil Uji untuk Permohonan Sampel dengan kode " . $titik->kode . " gagal dikirim. Silahkan hubungi admin.");
      //     }
      // }
    });
  }
}
