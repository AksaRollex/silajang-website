<?php

namespace App\Http\Controllers;

use App\Excel\RegistrasiSampelExcel;
use App\Helpers\AppHelper;
use App\Models\AcuanMetode;
use App\Models\Parameter;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\TandaTangan;
use App\Models\TitikPermohonan;
use App\Models\TitikPermohonanParameter;
use App\Models\TrackingPengujian;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\FontMetrics;
use Dompdf\Options;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\TemplateProcessor;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = TitikPermohonan::with(['permohonan.user.detail'])->where(function ($q) use ($request) {
                $q->where('kode', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('lokasi', 'LIKE', '%' . $request->search . '%');
                $q->orWhereHas('permohonan', function ($q) use ($request) {
                    $q->whereHas('user', function ($q) use ($request) {
                        $q->where('nama', 'LIKE', '%' . $request->search . '%');
                    });
                });
            })->when(isset($request->status), function ($q) use ($request) {
                $q->whereIn('status', $request->status);
            })
            // ->whereBetween('created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()])
            ->whereYear('created_at', $request->tahun)->whereMonth('created_at', $request->bulan)
            ->orderBy('kode', 'DESC')
            ->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            $data->map(function ($a) {
                $a->tanggal_diterima = $a->tanggal_diterima ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_diterima)->format('Y-m-d')) : '-';
                $a->tanggal_selesai = $a->tanggal_selesai ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_selesai)->format('Y-m-d')) : '-';
                $a->tanggal_tte = $a->tanggal_tte ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_tte)->format('Y-m-d')) : '-';
            });

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function reportError(Request $request) {
        $pdf = PDF::loadview('report.error', ['response' => $request->response]);
        $pdf->setPaper('A4');
        $pdf->output();

        return $pdf->stream('Error.pdf');
    }

    public function reportSampling(Request $request, $uuid)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['jasaPengambilan', 'user.detail']);
        }, 'peraturan', 'parameters'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $subkontrak = $request->subkontrak;
        $parametersUji = $data->parameters()->where('is_dapat_diuji', 1)->get();
        $parametersSubkontrak = $data->parameters()->where('is_dapat_diuji', 0)->get();

        $ttdKoradmin = TandaTangan::where('bagian', 'Pengambilan Sampel (Koordinator Administrasi)')->first();
        $ttdKortek = TandaTangan::where('bagian', 'Pengambilan Sampel (Koordinator Teknis)')->first();

        $pdf = PDF::loadview('report.pengambilan', compact('data', 'subkontrak', 'parametersUji', 'parametersSubkontrak', 'ttdKoradmin', 'ttdKortek'));
        $pdf->setPaper('A3');
        $pdf->output();

        $options = new Options();

        $canvas = $pdf->getDomPDF()->getCanvas();
        $fontMetrics = new FontMetrics($canvas, $options);
        $canvas->page_text(725, 1140, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $fontMetrics->get_font("Times New Roman", "bold"), 10, array(0, 0, 0));

        return $pdf->stream('Pengambilan-Sampling-' . $data->no_formulir . '.pdf');
    }

    public function reportBeritaAcara(Request $request, $uuid)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['jasaPengambilan', 'user.detail']);
        }, 'peraturan', 'parameters'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $subkontrak = $request->subkontrak;
        $parametersUji = $data->parameters()->where('is_dapat_diuji', 1)->get();
        $parametersSubkontrak = $data->parameters()->where('is_dapat_diuji', 0)->get();

        $pdf = PDF::loadview('report.berita-acara', compact('data', 'subkontrak', 'parametersUji', 'parametersSubkontrak'));
        $pdf->setPaper('A3');
        $pdf->output();

        $options = new Options();

        $canvas = $pdf->getDomPDF()->getCanvas();
        $fontMetrics = new FontMetrics($canvas, $options);
        $canvas->page_text(725, 1140, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $fontMetrics->get_font("Times New Roman", "bold"), 10, array(0, 0, 0));

        return $pdf->stream('Berita-Acara-' . $data->no_formulir . '.pdf');
    }

    public function reportDataPengambilan(Request $request, $uuid)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['jasaPengambilan', 'user.detail']);
        }, 'peraturan', 'parameters'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $subkontrak = $request->subkontrak;
        $parametersUji = $data->parameters()->where('is_dapat_diuji', 1)->get();
        $parametersSubkontrak = $data->parameters()->where('is_dapat_diuji', 0)->get();

        $pdf = PDF::loadview('report.data-pengambilan', compact('data', 'subkontrak', 'parametersUji', 'parametersSubkontrak'));
        $pdf->setPaper('A3');
        $pdf->output();

        $options = new Options();

        $canvas = $pdf->getDomPDF()->getCanvas();
        $fontMetrics = new FontMetrics($canvas, $options);
        $canvas->page_text(725, 1140, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $fontMetrics->get_font("Times New Roman", "bold"), 10, array(0, 0, 0));

        return $pdf->stream('Data-Pengambilan-' . $data->no_formulir . '.pdf');
    }

    public function reportTandaTerima(Request $request, $uuid)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['jasaPengambilan', 'user.detail']);
        }, 'peraturan', 'parameters'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $subkontrak = $request->subkontrak;
        $parametersUji = $data->parameters()->where('is_dapat_diuji', 1)->get();
        $parametersSubkontrak = $data->parameters()->where('is_dapat_diuji', 0)->get();

        $ttdKoradmin = TandaTangan::where('bagian', 'Pengambilan Sampel (Koordinator Administrasi)')->first();
        $ttdKortek = TandaTangan::where('bagian', 'Pengambilan Sampel (Koordinator Teknis)')->first();

        $pdf = Pdf::loadview('report.penerima', compact('data', 'subkontrak', 'parametersUji', 'parametersSubkontrak', 'ttdKoradmin', 'ttdKortek'));
        $pdf->setPaper('A3');
        $pdf->output();

        $options = new Options();

        $canvas = $pdf->getDomPDF()->getCanvas();
        $fontMetrics = new FontMetrics($canvas, $options);
        $canvas->page_text(725, 1140, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $fontMetrics->get_font("Times New Roman", "bold"), 10, array(0, 0, 0));

        return $pdf->stream('Tanda-Terima-Sampling-' . $data->no_formulir . '.pdf');
    }

    public function reportPengamananSampel(Request $request, $uuid)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['jasaPengambilan', 'user.detail']);
        }, 'peraturan', 'parameters'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $subkontrak = $request->subkontrak;
        $parametersUji = $data->parameters()->where('is_dapat_diuji', 1)->get();
        $pengawetans = $parametersUji->pluck('pengawetans')->flatten()->unique('nama')->values();

        $pdf = Pdf::loadview('report.pengamanan-sampel', compact('data', 'subkontrak', 'parametersUji', 'pengawetans'));
        $pdf->setPaper('A3');
        $pdf->output();

        $options = new Options();

        $canvas = $pdf->getDomPDF()->getCanvas();
        $fontMetrics = new FontMetrics($canvas, $options);
        $canvas->page_text(725, 1140, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $fontMetrics->get_font("Times New Roman", "bold"), 10, array(0, 0, 0));

        return $pdf->stream('Rangakaian-Pengamanan-Sampel-' . $data->no_formulir . '.pdf');
    }

    public function reportRDPS(Request $request, $uuid)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['jasaPengambilan', 'user.detail']);
        }, 'peraturan', 'parameters'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $subkontrak = $request->subkontrak;
        $parametersUji = $data->parameters()->where('is_dapat_diuji', 1)->get();
        $parametersSubkontrak = $data->parameters()->where('is_dapat_diuji', 0)->get();

        $ttd = TandaTangan::where('bagian', 'RDPS')->first();

        $pdf = Pdf::loadview('report.rdps', compact('data', 'subkontrak', 'parametersUji', 'parametersSubkontrak', 'ttd'));
        $pdf->setPaper('A3');
        $pdf->output();

        $options = new Options();

        $canvas = $pdf->getDomPDF()->getCanvas();
        $fontMetrics = new FontMetrics($canvas, $options);
        $canvas->page_text(725, 1140, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $fontMetrics->get_font("Arial", "bold"), 10, array(0, 0, 0));

        return $pdf->stream('RDPS-' . $data->no_formulir . '.pdf');
    }

    public function reportSPP(Request $request, $uuid)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['jasaPengambilan', 'user.detail']);
        }, 'peraturan', 'parameters'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $ttd = TandaTangan::where('bagian', 'SPP')->first();

        $parametersUji = $data->parameters()->where('is_dapat_diuji', 1)->pluck('parameters.id')->toArray();
        $analises = User::whereHas('roles', function ($q) {
            $q->where('name', 'analis');
        })->get();
        $analises = $analises->map(function ($a) use ($parametersUji, $data) {
            $parameters = $a->parameters()->whereIn('parameters.id', $parametersUji)->get();
            $parameters = $parameters->map(function ($b) use ($data) {
                $b->keterangan_uji = $data->parameters()->where('parameter_id', $b->id)->first()->pivot->keterangan;
                return $b;
            });
            $a->parameters = $parameters;
            return $a;
        });

        $pdf = Pdf::loadview('report.spp', compact('data', 'analises', 'ttd'));
        $pdf->setPaper('A3');
        $pdf->output();

        $options = new Options();

        $canvas = $pdf->getDomPDF()->getCanvas();
        $fontMetrics = new FontMetrics($canvas, $options);
        $canvas->page_text(725, 1140, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $fontMetrics->get_font("Arial", "bold"), 10, array(0, 0, 0));

        return $pdf->stream('SPP-' . $data->no_formulir . '.pdf');
    }

    public function reportPreviewLHU(Request $request, $uuid)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['jasaPengambilan', 'user.detail']);
        }, 'peraturan', 'parameters'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $parametersUji = $data->parameters()->get();
        $parametersUji = $parametersUji->groupBy(function ($a) {
            return $a->jenisParameter->id . '-' . $a->jenisParameter->nama;
        })->sortBy(function ($value, $key) {
            return $key;
        });

        $ttd = TandaTangan::where('bagian', 'Lembar Hasil Uji')->first();

        $preview = true;
        $setting = Setting::first();
        $pdf = Pdf::loadview('report.lhu', compact('data', 'parametersUji', 'ttd', 'preview', 'setting'));
        $pdf->setPaper('F4');
        $pdf->output();

        $options = new Options();

        $canvas = $pdf->getDomPDF()->getCanvas();
        $fontMetrics = new FontMetrics($canvas, $options);
        $canvas->page_text(250, 770, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $fontMetrics->get_font("Arial", "bold"), 10, array(0, 0, 0));

        return $pdf->stream('PREVIEW-LAPORAN-HASIL-PENGUJIAN-' . $data->kode . '.pdf');
    }

    public function reportLHU(Request $request, $uuid, $save = false, $tte = false, $base64 = false)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['jasaPengambilan', 'user.detail']);
        }, 'peraturan', 'parameters'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $save = filter_var($save, FILTER_VALIDATE_BOOLEAN);
        $tte = filter_var($tte, FILTER_VALIDATE_BOOLEAN);

        if (!$tte && $data->file_lhu && file_exists(storage_path('app/private/' . $data->file_lhu))) {
            return response()->file(storage_path('app/private/' . $data->file_lhu));
        }

        $parametersUji = $data->parameters()->get();
        $parametersUji = $parametersUji->groupBy(function ($a) {
            return $a->jenisParameter->id . '-' . $a->jenisParameter->nama;
        })->sortBy(function ($value, $key) {
            return $key;
        });

        $qrCode = $request->qrCode;

        $ttd = TandaTangan::where(function ($q) use ($request) {
            if (isset($request->tanda_tangan_id)) $q->where('id', $request->tanda_tangan_id);
            else $q->where('bagian', 'Lembar Hasil Uji');
        })->first();
        $setting = Setting::first();

        $pdf = Pdf::loadview('report.lhu', compact('data', 'tte', 'qrCode', 'parametersUji', 'ttd', 'setting'));
        $pdf->setPaper('F4');
        $pdf->output();

        $options = new Options();

        $canvas = $pdf->getDomPDF()->getCanvas();
        $fontMetrics = new FontMetrics($canvas, $options);
        $canvas->page_text(250, 770, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $fontMetrics->get_font("Arial", "bold"), 10, array(0, 0, 0));

        if ($base64) {
            if (!file_exists(storage_path('app/private/lhu'))) {
                mkdir(storage_path('app/private/lhu'), 0777, true);
            }

            file_put_contents(storage_path('app/private/lhu/LAPORAN-HASIL-PENGUJIAN-' . str_replace('/', '_', $data->kode) . '.pdf'), $pdf->output());
            return fopen(storage_path('app/private/lhu/LAPORAN-HASIL-PENGUJIAN-' . str_replace('/', '_', $data->kode) . '.pdf'), 'r');
        }

        // $pdf->setEncryption($data->permohonan->user->phone, "admin@silajang.go.id");

        if (!$save) {
            $data->update([
                'status' => 11,
                'sertifikat' => $data->sertifikat == 0 ? $data->sertifikat + 1 : $data->sertifikat
            ]);
            TrackingPengujian::create([
                'titik_permohonan_id' => $data->id,
                'status' => 11,
                'keterangan' => 'Selesai'
            ]);

            return $pdf->stream('LAPORAN-HASIL-PENGUJIAN-' . $data->kode . '.pdf');
        } else {
            $file = $pdf->download()->getOriginalContent();
            Storage::put('public/lhu/LAPORAN-HASIL-PENGUJIAN-' . str_replace('/', '_', $data->kode) . '.pdf', $file);

            return asset('storage/lhu/LAPORAN-HASIL-PENGUJIAN-' . str_replace('/', '_', $data->kode) . '.pdf');
        }
    }

    public function reportLHUWord(Request $request, $uuid, $save = false, $tte = false)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['jasaPengambilan', 'user.detail']);
        }, 'peraturan', 'parameters'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $tte = filter_var($tte, FILTER_VALIDATE_BOOLEAN);

        if (!$tte && $data->file_lhu && file_exists(storage_path('app/private/' . $data->file_lhu))) {
            return response()->file(storage_path('app/private/' . $data->file_lhu));
        }

        $parametersUji = $data->parameters()->get();
        $parametersUji = $parametersUji->groupBy(function ($a) {
            return $a->jenisParameter->id . '-' . $a->jenisParameter->nama;
        })->sortBy(function ($value, $key) {
            return $key;
        });

        $ttd = TandaTangan::where('bagian', 'Lembar Hasil Uji')->first();
        $setting = Setting::first();

        // $phpWord = new PhpWord();
        // $section = $phpWord->addSection();

        // $header = $section->addHeader();
        // $header->addImage(public_path($setting->kop_app), [
        //     'width' => 40,
        //     'height' => 50,
        //     'marginLeft' => 1,
        //     'wrappingStyle' => 'infront'
        // ]);
        // $header->addText('PEMERINTAH KABUPATEN JOMBANG', ['size' => 12, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 0]);
        // $header->addText('DINAS LINGKUNGAN HIDUP', ['size' => 12, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 0]);
        // $header->addText('UPT LABORATORIUM LINGKUNGAN', ['size' => 16, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 0]);
        // $header->addText($setting->alamat . ' Telp. ' . $setting->telepon, ['size' => 9, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 0]);
        // $header->addText('Email: ' . $setting->email . ', Website: ' . url(''), ['size' => 9, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 0]);
        // $header->addImage(public_path($setting->kop_sni), [
        //     'width' => 75,
        //     'height' => 40,
        //     'marginRight' => 1,
        //     'wrappingStyle' => 'infront'
        // ]);

        // $section->addText('LAPORAN HASIL PENGUJIAN', ['name' => 'Times New Roman', 'size' => 11, 'bold' => true, 'underline' => 'single'], ['alignment' => 'center', 'spaceAfter' => 0]);
        // $section->addText($data->no_lhu, ['name' => 'Times New Roman', 'size' => 11, 'bold' => true], ['alignment' => 'center']);

        $template = new TemplateProcessor(storage_path('app/LHU Srikandi.docx'));
        $template->setValue('no_lhu', $data->no_lhu);

        $template->setValue('kode', $data->kode);
        $template->setValue('nama_industri', $data->permohonan->industri);
        $template->setValue('alamat_industri', $data->permohonan->alamat);
        $template->setValue('telp', @$data->permohonan->user->detail->telepon ?? $data->permohonan->user->phone);
        $template->setValue('jenis_kegiatan', $data->permohonan->kegiatan);
        $template->setValue('jenis_sampel', $data->jenisSampel->nama);
        $template->setValue('rentang_pengujian', AppHelper::tanggal_indo(Carbon::parse($data->tanggal_diterima)->format('Y-m-d')) . 's/d ' . AppHelper::tanggal_indo(Carbon::parse($data->tanggal_selesai)->format('Y-m-d')));

        $template->setValue('instansi', $data->permohonan->user->detail->instansi);
        $template->setValue('alamat', $data->permohonan->user->detail->alamat);
        $template->setValue('petugas_pengambil', @$data->pengambil->nama);
        $template->setValue('tanggal_ambil', AppHelper::tanggal_indo(Carbon::parse($data->tanggal_pengambilan)->format('Y-m-d')) . ' / Jam ' . Carbon::parse($data->tanggal_pengambilan)->format('H:i'));
        $template->setValue('tanggal_terima', AppHelper::tanggal_indo(Carbon::parse($data->tanggal_diterima)->format('Y-m-d')) . ' / Jam ' . Carbon::parse($data->tanggal_diterima)->format('H:i'));
        $template->setValue('titik', "$data->lokasi S: $data->south E: $data->east");
        $template->setValue('metode', isset($data->acuanMetode) ? $data->acuanMetode->nama : '');

        if (isset($data->peraturan)) {
            $template->setValue('peraturan', $data->peraturan->nama . ' ' . $data->peraturan->nomor);
        } else {
            $template->setValue('peraturan', '');
        }

        if (isset($data->peraturan)) {
            if ($data->check()) {
                $template->setValue('interpretasi', 'Hasil Analisa Telah Memenuhi sesuai Baku Mutu ' . $data->peraturan->nama . ' ' . $data->peraturan->nomor);
            } else {
                $template->setValue('interpretasi', 'Hasil Analisa Tidak Memenuhi Baku Mutu ' . $data->peraturan->nama . ' ' . $data->peraturan->nomor);
            }
        } else {
            if ($data->check()) {
                $template->setValue('interpretasi', 'Hasil Analisa Telah Memenuhi sesuai Baku Mutu');
            } else {
                $template->setValue('interpretasi', 'Hasil Analisa Tidak Memenuhi Baku Mutu');
            }
        }

        $template->setValue('tanggal_naskah', AppHelper::tanggal_indo($data->getDoneAt()));
        $template->setValue('jabatan_pengirim', $ttd->jabatan);
        $template->setValue('nama_pengirim', $ttd->nama);
        $template->setValue('nip_pengirim', $ttd->nip);

        if (isset($tte) && $tte){
            $template->setValue('tte', 'Dokumen ini telah ditandatangani secara elektronik yang diterbitkan oleh Balai Sertifikasi Elektronik (BSrE), BSSN ');
            $template->setImageValue('img', array('path' => 'media/bse.png', 'width' => 110, 'height' => 60, 'ratio' => false));
        } else {
            $template->setValue('tte', '');
            $template->setValue('img', '');
        }

        $table = new Table(['borderSize' => 6, 'borderColor' => 'black', 'width' => 10500, 'unit' => TblWidth::TWIP]);

        $table->addRow(null, ['exactHeight' => true]);
        $table->addCell(550)->addText('No.', ['name' => 'Times New Roman', 'size' => 10, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 0]);
        $table->addCell(2900)->addText('Parameter', ['name' => 'Times New Roman', 'size' => 10, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 0]);
        $table->addCell(1100)->addText('Satuan', ['name' => 'Times New Roman', 'size' => 10, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 0]);
        $table->addCell(1000)->addText('Hasil Uji', ['name' => 'Times New Roman', 'size' => 10, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 0]);
        $table->addCell(1300)->addText('Baku Mutu*', ['name' => 'Times New Roman', 'size' => 10, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 0]);
        $table->addCell(2400)->addText('Metode Analisa', ['name' => 'Times New Roman', 'size' => 10, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 0]);
        $table->addCell(1250)->addText('Keterangan', ['name' => 'Times New Roman', 'size' => 10, 'bold' => true], ['alignment' => 'center', 'spaceAfter' => 0]);

        foreach ($parametersUji as $group => $parameters) {
            $table->addRow(null, ['exactHeight' => true]);
            $table->addCell(3000, ['gridSpan' => 7])->addText(explode('-', $group)[1], ['name' => 'Times New Roman', 'size' => 10, 'bold' => true], ['spaceAfter' => 0]);
            foreach ($parameters as $i => $param) {
                $tidakMemenuhi = TitikPermohonanParameter::getHasil($param->pivot) == 'Tidak Memenuhi';

                $table->addRow(null, ['exactHeight' => true]);
                $table->addCell(550)->addText($i + 1, ['name' => 'Times New Roman', 'size' => 10, 'bold' => $tidakMemenuhi], ['alignment' => 'center', 'spaceAfter' => 0]);
                $table->addCell(2900)->addText(htmlspecialchars($param->nama, ENT_QUOTES, 'UTF-8') . (!$param->is_akreditasi ? ' **' : '') . (!$param->is_dapat_diuji ? ' ***' : ''), ['name' => 'Times New Roman', 'size' => 10, 'bold' => $tidakMemenuhi], ['spaceAfter' => 0]);
                $table->addCell(1100)->addText(htmlspecialchars($param->pivot->satuan, ENT_QUOTES, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 10, 'bold' => $tidakMemenuhi], ['spaceAfter' => 0]);

                // $hasil_uji = str_replace('<', '&lt;', $param->pivot->hasil_uji_pembulatan);
                // $hasil_uji = str_replace('>', '&gt;', $hasil_uji);
                $table->addCell(1000)->addText(htmlspecialchars($param->pivot->hasil_uji_pembulatan, ENT_QUOTES, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 10, 'bold' => $tidakMemenuhi], ['spaceAfter' => 0]);
                if ($data->baku_mutu){
                    $table->addCell(1300)->addText(htmlspecialchars($param->pivot->baku_mutu, ENT_QUOTES, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 10, 'bold' => $tidakMemenuhi], ['spaceAfter' => 0]);
                } else {
                    $table->addCell(1300)->addText(htmlspecialchars('-', ENT_QUOTES, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 10, 'bold' => $tidakMemenuhi], ['spaceAfter' => 0]);
                }
                $table->addCell(2400)->addText(htmlspecialchars($param->metode, ENT_QUOTES, 'UTF-8'), ['name' => 'Times New Roman', 'size' => 10, 'bold' => $tidakMemenuhi], ['spaceAfter' => 0]);
                $table->addCell(1250)->addText('', ['name' => 'Times New Roman', 'size' => 10, 'bold' => $tidakMemenuhi], ['spaceAfter' => 0]);
            }
        }

        $template->setComplexBlock('table', $table);


        $kode = str_replace('/', '_', $data->kode);
        $template->saveAs(storage_path('app/lhu/LAPORAN-HASIL-PENGUJIAN-' . $kode . '.docx'));
        return response()->download(storage_path('app/lhu/LAPORAN-HASIL-PENGUJIAN-' . $kode . '.docx'));

        $data->update([
            'status' => 11,
            'sertifikat' => $data->sertifikat + 1
        ]);
        TrackingPengujian::create([
            'titik_permohonan_id' => $data->id,
            'status' => 11,
            'keterangan' => 'Selesai'
        ]);

        // $writer = IOFactory::createWriter($phpWord, 'Word2007');
        // $kode = str_replace('/', '_', $data->kode);
        // try {
        //     $writer->save(storage_path('app/lhu/LAPORAN-HASIL-PENGUJIAN-' . $kode . '.docx'));
        // } catch (Exception $e) {
        //     return response()->json([
        //         'message' => $e->getMessage()
        //     ], 500);
        // }

        // return response()->download(storage_path('app/lhu/LAPORAN-HASIL-PENGUJIAN-' . $kode . '.docx'));
    }

    public function reportSKRD(Request $request, $uuid, $tte = false, $base64 = false)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['user.detail']);
        }, 'parameters', 'payment'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $parametersUji = $data->parameters()->where('is_dapat_diuji', 1)->get();

        $ttdBayar = TandaTangan::where('bagian', 'Pembayaran')->first();
        $ttdUPT = TandaTangan::where(function ($q) use ($request) {
            if (isset($request->tanda_tangan_id)) $q->where('id', $request->tanda_tangan_id);
            else $q->where('bagian', 'Lembar Hasil Uji');
        })->first();
        $setting = Setting::first();

        $qrCode = $request->qrCode;

        $pdf = Pdf::loadview('report.skrd', compact('data', 'tte', 'qrCode', 'parametersUji', 'ttdBayar', 'ttdUPT', 'setting'));
        $pdf->setPaper('A3');
        $pdf->output();

        $options = new Options();

        $canvas = $pdf->getDomPDF()->getCanvas();
        $fontMetrics = new FontMetrics($canvas, $options);
        $canvas->page_text(350, 1160, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $fontMetrics->get_font("Arial", "bold"), 10, array(0, 0, 0));

        if ($base64) {
            if (!file_exists(storage_path('app/private/skrd'))) {
                mkdir(storage_path('app/private/skrd'), 0777, true);
            }

            file_put_contents(storage_path('app/private/skrd/SKRD-' . str_replace('/', '_', $data->kode) . '.pdf'), $pdf->output());
            return fopen(storage_path('app/private/skrd/SKRD-' . str_replace('/', '_', $data->kode) . '.pdf'), 'r');
        }

        return $pdf->stream('SKRD-' . $data->kode . '.pdf');
    }

    public function reportTagihanPembayaran(Request $request, $uuid)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['user.detail']);
        }, 'parameters', 'payment'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $ttdBayar = TandaTangan::where('bagian', 'Pembayaran')->first();
        $ttdUPT = TandaTangan::where('bagian', 'Lembar Hasil Uji')->first();
        $setting = Setting::first();

        if (!$data->payment->kode) $data->payment->genKode();

        $pdf = Pdf::loadview('report.tagihan-pembayaran', compact('data', 'ttdBayar', 'ttdUPT', 'setting'));
        $pdf->setPaper('A4', 'potrait');

        return $pdf->stream('Tagihan-Pembayaran-' . $data->kode . '.pdf');
    }

    public function reportKwitansi(Request $request, $uuid, $tte = false, $base64 = false)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['user.detail']);
        }, 'parameters', 'payment'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $qrCode = $request->qrCode;

        $ttd = TandaTangan::where(function ($q) use ($request) {
            if (isset($request->tanda_tangan_id)) $q->where('id', $request->tanda_tangan_id);
            else $q->where('bagian', 'Lembar Hasil Uji');
        })->first();
        $setting = Setting::first();

        if (!$data->payment->kode) $data->payment->genKode();

        $pdf = Pdf::loadview('report.kwitansi', compact('data', 'tte', 'qrCode', 'ttd', 'setting'));
        $pdf->setPaper('A4', 'landscape');

        if ($base64) {
            if (!file_exists(storage_path('app/private/kwitansi'))) {
                mkdir(storage_path('app/private/kwitansi'), 0777, true);
            }

            file_put_contents(storage_path('app/private/kwitansi/Kwitansi-' . str_replace('/', '_', $data->kode) . '.pdf'), $pdf->output());
            return fopen(storage_path('app/private/kwitansi/Kwitansi-' . str_replace('/', '_', $data->kode) . '.pdf'), 'r');
        }

        return $pdf->stream('Kwitansi-' . $data->kode . '.pdf');
    }

    public function reportBuktiPembayaran(Request $request, $uuid)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['user.detail']);
        }, 'parameters', 'payment'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $ttd = TandaTangan::where('bagian', 'Pembayaran')->first();

        $pdf = Pdf::loadview('report.bukti-pembayaran', compact('data', 'ttd'));
        $pdf->setPaper('A5', 'landscape');

        return $pdf->stream('Bukti-Pembayaran-' . $data->kode . '.pdf');
    }

    public function reportKendaliMutu(Request $request, $uuid, $tte = false, $base64 = false)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['jasaPengambilan', 'user.detail']);
        }, 'peraturan', 'parameters'])->where('uuid', $uuid)->first();

        if (!$data) {
            return abort(404);
        }

        $qrCode = $request->qrCode;

        $ttd = TandaTangan::where(function ($q) use ($request) {
            if (isset($request->tanda_tangan_id)) $q->where('id', $request->tanda_tangan_id);
            else $q->where('bagian', 'Kendali Mutu');
        })->first();

        $tracks = [];
        for ($i = 0; $i <= 10; $i++) {
            $tracks[] = $data->trackings()->where('status', $i)->orderBy('created_at', 'DESC')->first();
        }

        $pdf = Pdf::loadview('report.kendali-mutu', compact('data', 'tte', 'qrCode', 'ttd', 'tracks'));
        $pdf->setPaper('A3');
        $pdf->output();

        $options = new Options();

        $canvas = $pdf->getDomPDF()->getCanvas();
        $fontMetrics = new FontMetrics($canvas, $options);
        $canvas->page_text(725, 1140, "Halaman {PAGE_NUM} dari {PAGE_COUNT}", $fontMetrics->get_font("Arial", "bold"), 10, array(0, 0, 0));

        if ($base64) {
            if (!file_exists(storage_path('app/private/kendali-mutu'))) {
                mkdir(storage_path('app/private/kendali-mutu'), 0777, true);
            }

            file_put_contents(storage_path('app/private/kendali-mutu/LAPORAN-HASIL-PENGUJIAN-' . str_replace('/', '_', $data->no_formulir) . '.pdf'), $pdf->output());
            return fopen(storage_path('app/private/kendali-mutu/LAPORAN-HASIL-PENGUJIAN-' . str_replace('/', '_', $data->no_formulir) . '.pdf'), 'r');
        }

        return $pdf->stream('Kendali-Mutu-' . $data->no_formulir . '.pdf');
    }

    public function reportPembayaranPengujian(Request $request)
    {
        $data = TitikPermohonan::has('payment')->with(['permohonan' => function ($q) {
            $q->with(['user.detail']);
        }, 'parameters', 'payment'])->whereYear('created_at', $request->tahun)->whereMonth('created_at', $request->bulan)->orderBy('created_at', 'desc')->get();

        $pdf = Pdf::loadview('report.pembayaran-pengujian', compact('data'));
        $pdf->setPaper('A3');
        $pdf->output();

        return $pdf->stream('Pembayaran-Pengujian-' . Carbon::now()->format('d-m-Y') . '.pdf');
    }

    public function reportPembayaranNonPengujian(Request $request)
    {
        $data = Payment::where('titik_permohonan_id', null)->orderBy('created_at', 'desc')->whereYear('created_at', $request->tahun)->get();

        $pdf = Pdf::loadview('report.pembayaran-non-pengujian', compact('data'));
        $pdf->setPaper('A3');
        $pdf->output();

        return $pdf->stream('Pembayaran-Pengujian-' . Carbon::now()->format('d-m-Y') . '.pdf');
    }

    public function indexRekap(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = TitikPermohonan::with(['permohonan' => function ($q) {
                $q->with(['user', 'jasaPengambilan']);
            }, 'acuanMetode'])->where(function ($q) use ($request) {
                $q->where('kode', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('lokasi', 'LIKE', '%' . $request->search . '%');
                $q->orWhereHas('permohonan', function ($q) use ($request) {
                    $q->whereHas('user', function ($q) use ($request) {
                        $q->where('nama', 'LIKE', '%' . $request->search . '%');
                    });
                });
            })->when($request->is_mandiri != '-', function ($q) use ($request) {
                $q->whereHas('permohonan', function ($q) use ($request) {
                    $q->where('is_mandiri', $request->is_mandiri);
                });
            })->when($request->golongan_id != '-', function ($q) use ($request) {
                $q->whereHas('permohonan', function ($q) use ($request) {
                    $q->whereHas('user', function ($q) use ($request) {
                        $q->where('golongan_id', $request->golongan_id);
                    });
                });
            })->where('status', '>=', 2)->whereBetween('created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()])->orderBy('created_at', 'DESC')->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            $data->map(function ($a) {
                $a->tanggal_diterima = $a->tanggal_diterima ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_diterima)->format('Y-m-d')) : '-';
                $a->tanggal_selesai = $a->tanggal_selesai ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_selesai)->format('Y-m-d')) : '-';
            });

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function metodeRekap(Request $request)
    {
        $categories = AcuanMetode::pluck('nama')->toArray();
        $data = AcuanMetode::withCount(['titikPermohonans' => function ($q) use ($request) {
            $q->when($request->is_mandiri != '-', function ($q) use ($request) {
                $q->whereHas('permohonan', function ($q) use ($request) {
                    $q->where('is_mandiri', $request->is_mandiri);
                });
            })->when($request->golongan_id != '-', function ($q) use ($request) {
                $q->whereHas('permohonan', function ($q) use ($request) {
                    $q->whereHas('user', function ($q) use ($request) {
                        $q->where('golongan_id', $request->golongan_id);
                    });
                });
            })->where('status', '>=', 2)->whereBetween('created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()]);
        }])->get()->pluck('titik_permohonans_count')->toArray();

        return response()->json([
            'categories' => $categories,
            'data' => $data
        ]);
    }

    public function reportRekap(Request $request)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['user', 'jasaPengambilan']);
        }, 'acuanMetode'])
            ->when($request->is_mandiri != '-', function ($q) use ($request) {
                $q->whereHas('permohonan', function ($q) use ($request) {
                    $q->where('is_mandiri', $request->is_mandiri);
                });
            })->when($request->golongan_id != '-', function ($q) use ($request) {
                $q->whereHas('permohonan', function ($q) use ($request) {
                    $q->whereHas('user', function ($q) use ($request) {
                        $q->where('golongan_id', $request->golongan_id);
                    });
                });
            })->where('status', '>=', 2)->whereBetween('created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()])->orderBy('created_at', 'DESC')->get();

        $data = $data->map(function ($a) {
            $a->tanggal_diterima = $a->tanggal_diterima ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_diterima)->format('Y-m-d')) : '-';
            $a->tanggal_selesai = $a->tanggal_selesai ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_selesai)->format('Y-m-d')) : '-';

            return $a;
        });

        $mode = $request->mode;
        $setting = Setting::first();
        $start = $request->start;
        $end = $request->end;

        $pdf = Pdf::loadview('report.rekap-data', compact('data', 'mode', 'start', 'end', 'setting'));
        $pdf->setPaper('A3');
        $pdf->output();

        return $pdf->stream('Rekap-Data-' . ucfirst($mode) . '.pdf');
    }

    public function indexParameter(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Parameter::withCount(['titikPermohonans' => function ($q) use ($request) {
                $q->whereBetween('titik_permohonans.created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()]);
            }])->with(['titikPermohonans' => function ($q) use ($request) {
                $q->whereBetween('titik_permohonans.created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()]);
            }])->where(function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('keterangan', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('metode', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('satuan', 'LIKE', '%' . $request->search . '%');
                $q->orWhereHas('jenisParameter', function ($q) use ($request) {
                    $q->where('nama', 'LIKE', '%' . $request->search . '%');
                });
            })->whereHas('titikPermohonans', function ($q) use ($request) {
                $q->whereBetween('titik_permohonans.created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()]);
            })->orderBy('nama', 'ASC')->paginate($per, ['parameters.*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function reportParameter(Request $request)
    {
        $data = Parameter::withCount(['titikPermohonans' => function ($q) use ($request) {
            $q->whereBetween('titik_permohonans.created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()]);
        }])->with(['titikPermohonans' => function ($q) use ($request) {
            $q->whereBetween('titik_permohonans.created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()]);
        }])->where(function ($q) use ($request) {
            $q->where('nama', 'LIKE', '%' . $request->search . '%');
            $q->orWhere('keterangan', 'LIKE', '%' . $request->search . '%');
            $q->orWhere('metode', 'LIKE', '%' . $request->search . '%');
            $q->orWhere('satuan', 'LIKE', '%' . $request->search . '%');
            $q->orWhereHas('jenisParameter', function ($q) use ($request) {
                $q->where('nama', 'LIKE', '%' . $request->search . '%');
            });
        })->whereHas('titikPermohonans', function ($q) use ($request) {
            $q->whereBetween('titik_permohonans.created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()]);
        })->orderBy('nama', 'ASC')->get();

        $start = AppHelper::tanggal_indo($request->start);
        $end = AppHelper::tanggal_indo($request->end);
        $setting = Setting::first();

        $pdf = Pdf::loadview('report.rekap-parameter', compact('data', 'start', 'end', 'setting'));
        $pdf->setPaper('A3');
        $pdf->output();

        return $pdf->stream('Rekap-Parameter-' . $request->start . '-s/d-' . $request->end . '.pdf');
    }

    public function uploadLhu(Request $request, $uuid)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf'
        ]);

        $titik = TitikPermohonan::findByUuid($uuid);

        $file = $request->file->store('lhu', 'private');

        if ($titik->update(['file_lhu' => $file])) {
            return response()->json(['message' => 'File LHU berhasil diupload']);
        }

        return abort(500);
    }

    public function downloadLhu(Request $request, $uuid)
    {
        $titik = TitikPermohonan::findByUuid($uuid);

        if ($titik->permohonan->user_id != auth()->user()->id) {
            return abort(403);
        }

        return Storage::download('app/private/' . $titik->file_lhu);
    }

    public function indexRegistrasiSampel(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = TitikPermohonan::with(['permohonan' => function ($q) {
                $q->with(['user', 'jasaPengambilan']);
            }, 'acuanMetode'])->where(function ($q) use ($request) {
                $q->where('kode', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('lokasi', 'LIKE', '%' . $request->search . '%');
                $q->orWhereHas('permohonan', function ($q) use ($request) {
                    $q->whereHas('user', function ($q) use ($request) {
                        $q->where('nama', 'LIKE', '%' . $request->search . '%');
                    });
                });
            })->where('status', '>=', 2)
            // ->whereBetween('created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()])
            ->whereYear('created_at', $request->tahun)->whereMonth('created_at', $request->bulan)
            ->orderBy('created_at', 'DESC')
            ->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            $data->map(function ($a) {
                $a->tanggal_diterima = $a->tanggal_diterima ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_diterima)->format('Y-m-d')) : '-';
                $a->tanggal_selesai = $a->tanggal_selesai ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_selesai)->format('Y-m-d')) : '-';
            });

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function reportRegistrasiSampel(Request $request)
    {
        $data = TitikPermohonan::with(['permohonan' => function ($q) {
            $q->with(['user']);
        }])->where('status', '>=', 2)
        // ->whereBetween('created_at', [Carbon::parse($request->start)->startOfDay(), Carbon::parse($request->end)->endOfDay()])
        ->whereYear('created_at', $request->tahun)
        ->whereMonth('created_at', $request->bulan)
        ->orderBy('tanggal_diterima', 'ASC')->get();

        $data = $data->map(function ($a) {
            $a->tanggal_diterima = $a->tanggal_diterima ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_diterima)->format('Y-m-d')) : '-';
            $a->tanggal_selesai = $a->tanggal_selesai ? AppHelper::tanggal_indo(Carbon::parse($a->tanggal_selesai)->format('Y-m-d')) : '-';
            return $a;
        });

        $excel = new RegistrasiSampelExcel($data);
        $excel->download('Registrasi Sampel');
    }
}
