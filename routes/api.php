<?php

use App\Http\Controllers\AcuanMetodeController;
use App\Http\Controllers\AnalisController;
use App\Http\Controllers\SettingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\GlobalPaymentController;
use App\Http\Controllers\JasaPengambilanController;
use App\Http\Controllers\JenisParameterController;
use App\Http\Controllers\JenisSampelController;
use App\Http\Controllers\JenisWadahController;
use App\Http\Controllers\KabKotaController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\KelurahanController;
use App\Http\Controllers\KepalaUPTController;
use App\Http\Controllers\KeteranganUmpanBalikController;
use App\Http\Controllers\KodeRetribusiController;
use App\Http\Controllers\KoordinatorTeknisController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LiburCutiController;
use App\Http\Controllers\LogTTEController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\PaketParameterController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PenerimaSampelController;
use App\Http\Controllers\PengambilSampelController;
use App\Http\Controllers\PengawetanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\PeraturanController;
use App\Http\Controllers\PeraturanParameterController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\ProdukHukumController;
use App\Http\Controllers\RadiusPengambilanController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TandaTanganController;
use App\Http\Controllers\TitikPermohonanController;
use App\Http\Controllers\TitikPermohonanParameterController;
use App\Http\Controllers\TitikPermohonanPeraturanController;
use App\Http\Controllers\TrackingPengujianController;
use App\Http\Controllers\TTEController;
use App\Http\Controllers\UmpanBalikController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserParameterController;
use App\Http\Controllers\KontrakController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->middleware(['json'])->group(function () {
  Route::get('setting', [SettingController::class, 'index']);
  Route::prefix('konfigurasi')->group(function () {
    Route::get('layanan', [LayananController::class, 'get']);
    Route::get('layanan/{slug}', [LayananController::class, 'show']);

    Route::get('produk-hukum', [ProdukHukumController::class, 'get']);
    Route::get('produk-hukum/{slug}', [ProdukHukumController::class, 'show']);

    Route::get('faq', [FAQController::class, 'get']);
    Route::get('banner', [BannerController::class, 'get']);
    Route::get('pengumuman', [PengumumanController::class, 'get']);

    Route::post('umpan-balik/show', [UmpanBalikController::class, 'summary']);
  });

  Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('secure/login', [AuthController::class, 'secureLogin']);

    Route::post('getOtp', [AuthController::class, 'getOtp']);
    Route::post('register', [AuthController::class, 'register']);

    Route::post('register/get/email/otp', [AuthController::class, 'registerGetEmailOtp']);
    Route::post('register/get/phone/otp', [AuthController::class, 'registerGetPhoneOtp']);

    Route::post('register/check/email/otp', [AuthController::class, 'registerCheckEmailOtp']);
    Route::post('register/check/phone/otp', [AuthController::class, 'registerCheckPhoneOtp']);

    Route::middleware(['auth', 'verified'])->group(function () {
      Route::get('', [AuthController::class, 'index']);
      Route::post('logout', [AuthController::class, 'logout']);

      Route::middleware(['role:admin'])->get('whatsapp', [AuthController::class, 'whatsapp']);
    });
  });

  Route::prefix('wilayah')->group(function () {
    Route::get('kota-kabupaten', [KabKotaController::class, 'get']);

    Route::prefix('kota-kabupaten/{pid}/kecamatan')->group(function () {
      Route::get('', [KecamatanController::class, 'get']);
      Route::get('{id}', [KecamatanController::class, 'show']);
    });

    Route::prefix('kecamatan/{pid}/kelurahan')->group(function () {
      Route::get('', [KelurahanController::class, 'get']);
      Route::get('{id}', [KelurahanController::class, 'show']);
    });
  });

  Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('dashboard')->group(function () {
      Route::post('admin', [DashboardController::class, 'indexAdmin'])->middleware(['role:admin|koordinator-teknis|kepala-upt|analis|koordinator-administrasi']);
      Route::post('customer', [DashboardController::class, 'indexCustomer'])->middleware(['role:customer']);
    });

    Route::prefix('user')->group(function () {
      Route::post('account', [UserController::class, 'updateAccount']);
      Route::post('company', [UserController::class, 'updateCompany']);
      Route::post('security', [UserController::class, 'updateSecurity']);
    });

    Route::prefix('master')->group(function () {
      Route::prefix('kota-kabupaten')->group(function () {
        Route::get('', [KabKotaController::class, 'get']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('', [KabKotaController::class, 'index']);
          Route::post('store', [KabKotaController::class, 'store']);
          Route::get('{uuid}/edit', [KabKotaController::class, 'edit']);
          Route::post('{uuid}/update', [KabKotaController::class, 'update']);
          Route::delete('{uuid}', [KabKotaController::class, 'destroy']);
        });
      });

      Route::prefix('kecamatan')->group(function () {
        Route::get('', [KecamatanController::class, 'get']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('', [KecamatanController::class, 'index']);
          Route::post('store', [KecamatanController::class, 'store']);
          Route::get('{uuid}/edit', [KecamatanController::class, 'edit']);
          Route::post('{uuid}/update', [KecamatanController::class, 'update']);
          Route::delete('{uuid}', [KecamatanController::class, 'destroy']);
        });
      });

      Route::prefix('kelurahan')->group(function () {
        Route::get('', [KelurahanController::class, 'get']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('', [KelurahanController::class, 'index']);
          Route::post('store', [KelurahanController::class, 'store']);
          Route::get('{uuid}/edit', [KelurahanController::class, 'edit']);
          Route::post('{uuid}/update', [KelurahanController::class, 'update']);
          Route::delete('{uuid}', [KelurahanController::class, 'destroy']);
        });
      });

      Route::prefix('acuan-metode')->group(function () {
        Route::get('', [AcuanMetodeController::class, 'get']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('', [AcuanMetodeController::class, 'index']);
          Route::post('store', [AcuanMetodeController::class, 'store']);
          Route::get('{uuid}/edit', [AcuanMetodeController::class, 'edit']);
          Route::post('{uuid}/update', [AcuanMetodeController::class, 'update']);
          Route::delete('{uuid}', [AcuanMetodeController::class, 'destroy']);
        });
      });

      Route::prefix('pengawetan')->group(function () {
        Route::get('', [PengawetanController::class, 'get']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('', [PengawetanController::class, 'index']);
          Route::post('store', [PengawetanController::class, 'store']);
          Route::get('{uuid}/edit', [PengawetanController::class, 'edit']);
          Route::post('{uuid}/update', [PengawetanController::class, 'update']);
          Route::delete('{uuid}', [PengawetanController::class, 'destroy']);
        });
      });

      Route::prefix('parameter')->group(function () {
        Route::get('', [ParameterController::class, 'get']);
        Route::post('', [ParameterController::class, 'index']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('store', [ParameterController::class, 'store']);
          Route::get('{uuid}/edit', [ParameterController::class, 'edit']);
          Route::post('{uuid}/update', [ParameterController::class, 'update']);
          Route::delete('{uuid}', [ParameterController::class, 'destroy']);
        });
      });

      Route::prefix('jenis-parameter')->group(function () {
        Route::get('', [JenisParameterController::class, 'get']);
      });

      Route::prefix('peraturan')->group(function () {
        Route::get('', [PeraturanController::class, 'get']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('', [PeraturanController::class, 'index']);
          Route::post('store', [PeraturanController::class, 'store']);
          Route::get('{uuid}/edit', [PeraturanController::class, 'edit']);
          Route::post('{uuid}/update', [PeraturanController::class, 'update']);
          Route::delete('{uuid}', [PeraturanController::class, 'destroy']);
        });

        Route::prefix('{peraturan}/parameter')->group(function () {
          Route::get('', [PeraturanParameterController::class, 'get']);

          Route::middleware(['role:admin'])->group(function () {
            Route::post('', [PeraturanParameterController::class, 'index']);
            Route::post('store', [PeraturanParameterController::class, 'store']);
            Route::post('update', [PeraturanParameterController::class, 'update']);
            Route::post('destroy', [PeraturanParameterController::class, 'destroy']);
          });
        });
      });

      Route::prefix('paket')->group(function () {
        Route::get('', [PaketController::class, 'get']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('', [PaketController::class, 'index']);
          Route::post('store', [PaketController::class, 'store']);
          Route::get('{uuid}/edit', [PaketController::class, 'edit']);
          Route::post('{uuid}/update', [PaketController::class, 'update']);
          Route::delete('{uuid}', [PaketController::class, 'destroy']);
        });

        Route::prefix('{paket}/parameter')->group(function () {
          Route::get('', [PaketParameterController::class, 'get']);

          Route::middleware(['role:admin'])->group(function () {
            Route::post('', [PaketParameterController::class, 'index']);
            Route::post('store', [PaketParameterController::class, 'store']);
            Route::post('destroy', [PaketParameterController::class, 'destroy']);
          });
        });
      });

      Route::prefix('jenis-sampel')->group(function () {
        Route::get('', [JenisSampelController::class, 'get']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('', [JenisSampelController::class, 'index']);
          Route::post('store', [JenisSampelController::class, 'store']);
          Route::get('{uuid}/edit', [JenisSampelController::class, 'edit']);
          Route::post('{uuid}/update', [JenisSampelController::class, 'update']);
          Route::delete('{uuid}', [JenisSampelController::class, 'destroy']);
        });
      });

      Route::prefix('jenis-wadah')->group(function () {
        Route::get('', [JenisWadahController::class, 'get']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('', [JenisWadahController::class, 'index']);
          Route::post('store', [JenisWadahController::class, 'store']);
          Route::get('{uuid}/edit', [JenisWadahController::class, 'edit']);
          Route::post('{uuid}/update', [JenisWadahController::class, 'update']);
          Route::delete('{uuid}', [JenisWadahController::class, 'destroy']);
        });
      });

      Route::prefix('jasa-pengambilan')->group(function () {
        Route::get('', [JasaPengambilanController::class, 'get']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('', [JasaPengambilanController::class, 'index']);
          Route::post('store', [JasaPengambilanController::class, 'store']);
          Route::get('{uuid}/edit', [JasaPengambilanController::class, 'edit']);
          Route::post('{uuid}/update', [JasaPengambilanController::class, 'update']);
          Route::delete('{uuid}', [JasaPengambilanController::class, 'destroy']);
        });
      });

      Route::prefix('radius-pengambilan')->group(function () {
        Route::get('', [RadiusPengambilanController::class, 'get']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('', [RadiusPengambilanController::class, 'index']);
          Route::post('store', [RadiusPengambilanController::class, 'store']);
          Route::get('{uuid}/edit', [RadiusPengambilanController::class, 'edit']);
          Route::post('{uuid}/update', [RadiusPengambilanController::class, 'update']);
          Route::delete('{uuid}', [RadiusPengambilanController::class, 'destroy']);
        });
      });

      Route::prefix('libur-cuti')->group(function () {
        Route::get('', [LiburCutiController::class, 'get']);
        Route::post('', [LiburCutiController::class, 'index']);
        Route::post('store', [LiburCutiController::class, 'store']);
        Route::get('{uuid}/edit', [LiburCutiController::class, 'edit']);
        Route::post('{uuid}/update', [LiburCutiController::class, 'update']);
        Route::delete('{uuid}', [LiburCutiController::class, 'destroy']);
      });

      Route::prefix('kode-retribusi')->group(function () {
        Route::get('', [KodeRetribusiController::class, 'get']);

        Route::middleware(['role:admin'])->group(function () {
          Route::post('', [KodeRetribusiController::class, 'index']);
          Route::post('store', [KodeRetribusiController::class, 'store']);
          Route::get('{uuid}/edit', [KodeRetribusiController::class, 'edit']);
          Route::post('{uuid}/update', [KodeRetribusiController::class, 'update']);
          Route::delete('{uuid}', [KodeRetribusiController::class, 'destroy']);
        });
      });

      Route::prefix('jabatan')->middleware(['role:admin'])->group(function () {
        Route::get('', [RoleController::class, 'get']);
        Route::post('', [RoleController::class, 'index']);
        Route::post('store', [RoleController::class, 'store']);
        Route::get('{name}/edit', [RoleController::class, 'edit']);
        Route::post('{name}/update', [RoleController::class, 'update']);
        Route::delete('{name}', [RoleController::class, 'destroy']);
      });

      Route::prefix('user')->group(function () {
        Route::get('', [UserController::class, 'get']);
        Route::post('', [UserController::class, 'index']);
        Route::post('store', [UserController::class, 'store']);
        Route::get('{uuid}/edit', [UserController::class, 'edit']);
        Route::post('{uuid}/update', [UserController::class, 'update']);
        Route::post('{uuid}/confirm', [UserController::class, 'confirm']);
        Route::delete('{uuid}', [UserController::class, 'destroy']);

        Route::prefix('{role}/parameter')->group(function () {
          Route::post('', [UserParameterController::class, 'index']);
          Route::get('', [UserParameterController::class, 'get']);
          Route::post('store', [UserParameterController::class, 'store']);
          Route::post('destroy', [UserParameterController::class, 'destroy']);
        });
      });
    });

    Route::prefix('konfigurasi')->group(function () {
      Route::post('setting', [SettingController::class, 'update'])->middleware(['role:admin']);

      Route::prefix('layanan')->middleware(['role:admin'])->group(function () {
        Route::post('', [LayananController::class, 'index']);
        Route::post('store', [LayananController::class, 'store']);
        Route::get('{uuid}/edit', [LayananController::class, 'edit']);
        Route::post('{uuid}/update', [LayananController::class, 'update']);
        Route::delete('{uuid}', [LayananController::class, 'destroy']);

        Route::post('upload-image', [LayananController::class, 'uploadImage'])->middleware('optimizeImages');
        Route::post('remove-image', [LayananController::class, 'removeImage']);
      });

      Route::prefix('produk-hukum')->middleware(['role:admin'])->group(function () {
        Route::post('', [ProdukHukumController::class, 'index']);
        Route::post('store', [ProdukHukumController::class, 'store']);
        Route::get('{uuid}/edit', [ProdukHukumController::class, 'edit']);
        Route::post('{uuid}/update', [ProdukHukumController::class, 'update']);
        Route::delete('{uuid}', [ProdukHukumController::class, 'destroy']);

        Route::post('upload-image', [ProdukHukumController::class, 'uploadImage'])->middleware('optimizeImages');
        Route::post('remove-image', [ProdukHukumController::class, 'removeImage']);
      });

      Route::prefix('faq')->middleware(['role:admin'])->group(function () {
        Route::post('', [FAQController::class, 'index']);
        Route::post('store', [FAQController::class, 'store']);
        Route::get('{uuid}/edit', [FAQController::class, 'edit']);
        Route::post('{uuid}/update', [FAQController::class, 'update']);
        Route::delete('{uuid}', [FAQController::class, 'destroy']);
      });

      Route::prefix('banner')->middleware(['role:admin'])->group(function () {
        Route::post('', [BannerController::class, 'index']);
        Route::post('store', [BannerController::class, 'store']);
        Route::get('{uuid}/edit', [BannerController::class, 'edit']);
        Route::post('{uuid}/update', [BannerController::class, 'update']);
        Route::delete('{uuid}', [BannerController::class, 'destroy']);
      });

      Route::prefix('pengumuman')->middleware(['role:admin'])->group(function () {
        Route::post('', [PengumumanController::class, 'index']);
        Route::post('store', [PengumumanController::class, 'store']);
        Route::get('{uuid}/edit', [PengumumanController::class, 'edit']);
        Route::post('{uuid}/update', [PengumumanController::class, 'update']);
        Route::delete('{uuid}', [PengumumanController::class, 'destroy']);
      });

      Route::prefix('tanda-tangan')->middleware(['role:admin|kepala-upt'])->group(function () {
        Route::get('', [TandaTanganController::class, 'get']);
        Route::post('', [TandaTanganController::class, 'index']);
        Route::get('{name}/edit', [TandaTanganController::class, 'edit']);
        Route::post('{name}/update', [TandaTanganController::class, 'update']);
      });

      Route::prefix('log-tte')->middleware(['role:admin'])->group(function () {
        Route::get('', [LogTTEController::class, 'get']);
        Route::post('', [LogTTEController::class, 'index']);
      });

      Route::prefix('umpan-balik')->middleware(['role:admin'])->group(function () {
        Route::post('', [UmpanBalikController::class, 'index']);
        Route::post('summary', [UmpanBalikController::class, 'summary']);
        Route::post('reset', [UmpanBalikController::class, 'resetSummary']);
        Route::get('template', [UmpanBalikController::class, 'templateImport']);
        Route::post('import', [UmpanBalikController::class, 'importData']);

        Route::prefix('keterangan')->group(function () {
          Route::post('', [KeteranganUmpanBalikController::class, 'index']);
          Route::get('{uuid}/edit', [KeteranganUmpanBalikController::class, 'edit']);
          Route::post('{uuid}/update', [KeteranganUmpanBalikController::class, 'update']);
        });
      });

      Route::prefix('umpan-balik')->group(function () {
        Route::post('send', [UmpanBalikController::class, 'send']);

        Route::prefix('keterangan')->group(function () {
          Route::get('', [KeteranganUmpanBalikController::class, 'show']);
        });
      });
    });

    Route::prefix('permohonan')->middleware(['role:customer'])->group(function () {
      Route::get('{uuid}', [PermohonanController::class, 'show']);
      Route::post('', [PermohonanController::class, 'index']);
      Route::post('store', [PermohonanController::class, 'store']);
      Route::get('{uuid}/edit', [PermohonanController::class, 'edit']);
      Route::post('{uuid}/update', [PermohonanController::class, 'update']);
      Route::delete('{uuid}', [PermohonanController::class, 'destroy']);

      Route::prefix('titik')->group(function () {
        Route::get('{uuid}', [TitikPermohonanController::class, 'show']);
        Route::post('', [TitikPermohonanController::class, 'index']);
        Route::post('store', [TitikPermohonanController::class, 'store']);
        Route::get('{uuid}/edit', [TitikPermohonanController::class, 'edit']);
        Route::post('{uuid}/status-tte', [TitikPermohonanController::class, 'statusTte'])->withoutMiddleware(['role:customer']);
        Route::post('{uuid}/update', [TitikPermohonanController::class, 'update']);
        Route::post('{uuid}/save-parameter', [TitikPermohonanController::class, 'saveParameter']);
        Route::delete('{uuid}', [TitikPermohonanController::class, 'destroy']);

        Route::prefix('{titik}/peraturan')->group(function () {
          Route::post('', [TitikPermohonanPeraturanController::class, 'index']);
          Route::post('store', [TitikPermohonanPeraturanController::class, 'store']);
          Route::post('destroy', [TitikPermohonanPeraturanController::class, 'destroy']);
        });

        Route::prefix('{titik}/parameter')->group(function () {
          Route::get('', [TitikPermohonanParameterController::class, 'get']);
          Route::post('', [TitikPermohonanParameterController::class, 'index']);
          Route::post('store', [TitikPermohonanParameterController::class, 'store']);
          Route::post('store/paket', [TitikPermohonanParameterController::class, 'storeFromPaket']);
          Route::post('update', [TitikPermohonanParameterController::class, 'update']);
          Route::post('destroy', [TitikPermohonanParameterController::class, 'destroy']);
          Route::post('destroy/paket', [TitikPermohonanParameterController::class, 'destroyFromPaket']);
        });
      });
    });

    Route::prefix('tracking')->group(function () {
      Route::post('', [TrackingPengujianController::class, 'index']);
      Route::get('{uuid}', [TrackingPengujianController::class, 'show']);
    });

    Route::prefix('administrasi')->group(function () {
      Route::prefix('kontrak')->middleware(['role:admin'])->group(function () {
        Route::post('', [KontrakController::class, 'index']);
        Route::get('{uuid}', [KontrakController::class, 'show']);
        Route::post('{uuid}/update', [KontrakController::class, 'update']);
      });

      Route::prefix('pengambil-sample')->middleware(['role:admin|pengambil-sample|koordinator-administrasi'])->group(function () {
        Route::post('', [PengambilSampelController::class, 'index']);
        Route::get('petugas', [PengambilSampelController::class, 'petugas']);
        Route::get('{uuid}', [PengambilSampelController::class, 'show']);
        Route::post('{uuid}/update', [PengambilSampelController::class, 'update']);
        Route::post('{uuid}/update-status', [PengambilSampelController::class, 'updateStatus']);
        Route::post('{uuid}/upload-photo', [PengambilSampelController::class, 'uploadPhoto'])->middleware('optimizeImages');
      });

      Route::prefix('penerima-sample')->middleware(['role:admin|koordinator-administrasi|koordinator-teknis'])->group(function () {
        Route::post('', [PenerimaSampelController::class, 'index']);
        Route::get('{uuid}', [PenerimaSampelController::class, 'show']);
        Route::post('{uuid}/update', [PenerimaSampelController::class, 'update']);
        Route::post('{uuid}/update-status', [PenerimaSampelController::class, 'updateStatus']);
        Route::post('{uuid}/revisi', [PenerimaSampelController::class, 'revisi']);
      });
    });

    Route::prefix('verifikasi')->group(function () {
      Route::prefix('analis')->middleware(['role:admin|analis'])->group(function () {
        Route::post('', [AnalisController::class, 'index']);
        Route::get('{uuid}', [AnalisController::class, 'show']);
        Route::post('{uuid}/fill-parameter', [AnalisController::class, 'fillParameter']);
      });

      Route::prefix('koordinator-teknis')->middleware(['role:admin|koordinator-teknis'])->group(function () {
        Route::post('', [KoordinatorTeknisController::class, 'index']);
        Route::get('{uuid}', [KoordinatorTeknisController::class, 'show']);
        Route::post('{uuid}/fill-parameter', [KoordinatorTeknisController::class, 'fillParameter']);
        Route::post('{uuid}/reject', [KoordinatorTeknisController::class, 'reject']);
      });

      Route::prefix('kepala-upt')->middleware(['role:admin|kepala-upt'])->group(function () {
        Route::post('', [KepalaUPTController::class, 'index']);
        Route::get('{uuid}', [KepalaUPTController::class, 'show']);
        Route::post('{uuid}/verify', [KepalaUPTController::class, 'verify']);
        Route::post('{uuid}/rollback', [KepalaUPTController::class, 'rollback']);
      });
    });

    Route::prefix('pembayaran')->group(function () {
      Route::prefix('pengujian')->group(function () {
        Route::post('', [PembayaranController::class, 'index']);
        Route::post('whatsapp', [PembayaranController::class, 'whatsapp']);
        Route::get('{uuid}', [PembayaranController::class, 'show']);
        Route::post('{uuid}', [PembayaranController::class, 'store']);

        Route::middleware(['role:admin|koordinator-teknis|koordinator-administrasi'])->group(function () {
          Route::post('{uuid}/cancel', [PembayaranController::class, 'cancel']);
          Route::post('{uuid}/check', [PembayaranController::class, 'check']);
        });
      });

      Route::prefix('non-pengujian')->middleware(['role:admin|koordinator-teknis|koordinator-administrasi|kepala-upt'])->group(function () {
        Route::get('', [PaymentController::class, 'get']);
        Route::post('', [PaymentController::class, 'index']);
        Route::post('store', [PaymentController::class, 'store']);
        Route::get('{uuid}/edit', [PaymentController::class, 'edit']);
        Route::delete('{uuid}', [PaymentController::class, 'destroy']);
      });

      Route::prefix('global')->middleware(['role:admin|koordinator-teknis|koordinator-administrasi|kepala-upt'])->group(function () {
        Route::post('', [GlobalPaymentController::class, 'index']);
        Route::get('report', [GlobalPaymentController::class, 'report']);
      });
    });
  });
});

Route::prefix('v1')->middleware(['auth'])->group(function () {
  Route::prefix('report')->group(function () {
    Route::post('', [ReportController::class, 'index']);
    Route::post('{uuid}/upload', [ReportController::class, 'uploadLhu']);
    // Route::post('{uuid}/download', [ReportController::class, 'downloadLhu']);

    Route::get('{uuid}/sampling', [ReportController::class, 'reportSampling']);
    Route::get('{uuid}/berita-acara', [ReportController::class, 'reportBeritaAcara']);
    Route::get('{uuid}/data-pengambilan', [ReportController::class, 'reportDataPengambilan']);

    Route::get('{uuid}/tanda-terima', [ReportController::class, 'reportTandaTerima']);
    Route::get('{uuid}/pengamanan-sampel', [ReportController::class, 'reportPengamananSampel']);

    Route::get('{uuid}/rdps', [ReportController::class, 'reportRDPS']);
    Route::get('{uuid}/spp', [ReportController::class, 'reportSPP']);

    Route::get('{uuid}/preview-lhu', [ReportController::class, 'reportPreviewLHU']);

    Route::get('{uuid}/lhu/tte', [TTEController::class, 'postLhu']);
    Route::get('{uuid}/lhu/tte/download', [TTEController::class, 'downloadLhu']);

    Route::get('{uuid}/lhu/word', [ReportController::class, 'reportLHUWord']);
    Route::get('{uuid}/lhu/{save?}/{tte?}', [ReportController::class, 'reportLHU']);

    Route::get('{uuid}/kendali-mutu', [ReportController::class, 'reportKendaliMutu']);
    Route::get('{uuid}/kendali-mutu/tte', [TTEController::class, 'postKendaliMutu']);
    Route::get('{uuid}/kendali-mutu/tte/download', [TTEController::class, 'downloadKendaliMutu']);

    Route::get('{uuid}/skrd', [ReportController::class, 'reportSKRD']);
    Route::get('{uuid}/skrd/tte', [TTEController::class, 'postSKRD']);
    Route::get('{uuid}/skrd/tte/download', [TTEController::class, 'downloadSKRD']);

    Route::get('{uuid}/kwitansi', [ReportController::class, 'reportKwitansi']);
    Route::get('{uuid}/kwitansi/tte', [TTEController::class, 'postKwitansi']);
    Route::get('{uuid}/kwitansi/tte/download', [TTEController::class, 'downloadKwitansi']);

    Route::get('{uuid}/tagihan-pembayaran', [ReportController::class, 'reportTagihanPembayaran']);
    Route::get('{uuid}/bukti-pembayaran', [ReportController::class, 'reportBuktiPembayaran']);

    Route::get('pembayaran/pengujian', [ReportController::class, 'reportPembayaranPengujian']);
    Route::get('pembayaran/non-pengujian', [ReportController::class, 'reportPembayaranNonPengujian']);

    Route::prefix('registrasi-sampel')->group(function () {
      Route::post('', [ReportController::class, 'indexRegistrasiSampel']);
      Route::get('', [ReportController::class, 'reportRegistrasiSampel']);
    });

    Route::prefix('rekap')->group(function () {
      Route::post('', [ReportController::class, 'indexRekap']);
      Route::post('metode', [ReportController::class, 'metodeRekap']);
      Route::get('', [ReportController::class, 'reportRekap']);
    });

    Route::prefix('parameter')->group(function () {
      Route::post('', [ReportController::class, 'indexParameter']);
      Route::get('', [ReportController::class, 'reportParameter']);
    });
  });
});

Route::post('payment/post', [PaymentController::class, 'post']);
