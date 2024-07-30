<?php

namespace App\Http\Controllers;

use App\Models\Parameter;
use App\Models\Payment;
use App\Models\Peraturan;
use App\Models\TitikPermohonan;
use App\Models\UmpanBalik;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function indexAdmin(Request $request)
    {
        $customers = User::where('golongan_id', 1)->whereYear('created_at', $request->tahun)->count();
        $newSampels = TitikPermohonan::has('parameters')->whereHas('permohonan', function ($q) {
            $q->where('is_mandiri', 0);
        })->where('status', 0)->whereYear('created_at', $request->tahun)->count();
        $undoneSampels = TitikPermohonan::where('status', '>', 1)->where('status', '<=', 3)->whereYear('created_at', $request->tahun)->count();
        $unverifSampels = TitikPermohonan::where('status', '>=', 4)->where('status', '<=', 6)->whereYear('created_at', $request->tahun)->count();
        $allSampels = TitikPermohonan::whereYear('created_at', $request->tahun)->count();
        $revenue = Payment::whereYear('created_at', $request->tahun)->where('is_lunas', 1)->sum('jumlah');

        $chartSampels = [
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'data' => [],
        ];
        for ($i = 1; $i <= 12; $i++) {
            $chartSampels['data'][$i - 1] = TitikPermohonan::whereMonth('created_at', $i)->whereYear('created_at', $request->tahun)->count();
        }

        $peraturans = Peraturan::withCount(['titikPermohonans' => function ($q) use ($request) {
            $q->whereYear('titik_permohonans.created_at', $request->tahun);
        }])->orderBy('titik_permohonans_count', 'desc')->take(5)->get();
        $parameters = Parameter::withCount(['titikPermohonans' => function ($q) use ($request) {
            $q->whereYear('titik_permohonans.created_at', $request->tahun);
        }])->orderBy('titik_permohonans_count', 'desc')->take(5)->get();

        $chartPeraturans = [
            'categories' => [],
            'data' => [],
        ];
        foreach ($peraturans as $peraturan) {
            if ($peraturan->titik_permohonans_count) {
                $chartPeraturans['categories'][] = $peraturan->nama . ' ' . $peraturan->nomor . ($peraturan->tentang ? " ($peraturan->tentang)" : '');
                $chartPeraturans['data'][] = $peraturan->titik_permohonans_count;
            }
        }

        $chartParameters = [
            'categories' => [],
            'data' => [],
        ];
        foreach ($parameters as $parameter) {
            if ($parameter->titik_permohonans_count) {
                $chartParameters['categories'][] = $parameter->nama . ($parameter->keterangan ? " ($parameter->keterangan)" : '');
                $chartParameters['data'][] = $parameter->titik_permohonans_count;
            }
        }

        $umpanBaliks = UmpanBalik::select(DB::raw('SUM(u1)/COUNT(id) as u1'), DB::raw('SUM(u2)/COUNT(id) as u2'), DB::raw('SUM(u3)/COUNT(id) as u3'), DB::raw('SUM(u4)/COUNT(id) as u4'), DB::raw('SUM(u5)/COUNT(id) as u5'), DB::raw('SUM(u6)/COUNT(id) as u6'), DB::raw('SUM(u7)/COUNT(id) as u7'), DB::raw('SUM(u8)/COUNT(id) as u8'), DB::raw('SUM(u9)/COUNT(id) as u9'), DB::raw('COUNT(id) as jumlah'))->where('tahun', $request->tahun)->first();
        $total = 0;
        $ikm = 0;

        $umpanBaliks['u1'] = (float)$umpanBaliks['u1'];
        $umpanBaliks['u2'] = (float)$umpanBaliks['u2'];
        $umpanBaliks['u3'] = (float)$umpanBaliks['u3'];
        $umpanBaliks['u4'] = (float)$umpanBaliks['u4'];
        $umpanBaliks['u5'] = (float)$umpanBaliks['u5'];
        $umpanBaliks['u6'] = (float)$umpanBaliks['u6'];
        $umpanBaliks['u7'] = (float)$umpanBaliks['u7'];
        $umpanBaliks['u8'] = (float)$umpanBaliks['u8'];
        $umpanBaliks['u9'] = (float)$umpanBaliks['u9'];

        $total += ($umpanBaliks['u1']);
        $total += ($umpanBaliks['u2']);
        $total += ($umpanBaliks['u3']);
        $total += ($umpanBaliks['u4']);
        $total += ($umpanBaliks['u5']);
        $total += ($umpanBaliks['u6']);
        $total += ($umpanBaliks['u7']);
        $total += ($umpanBaliks['u8']);
        $total += ($umpanBaliks['u9']);

        $total = $total / 9;

        $ikm = $total * 25;

        return response()->json([
            'customers' => $customers,
            'newSampels' => $newSampels,
            'undoneSampels' => $undoneSampels,
            'unverifSampels' => $unverifSampels,
            'allSampels' => $allSampels,
            'revenue' => $revenue,
            'chartSampels' => $chartSampels,
            'chartPeraturans' => $chartPeraturans,
            'chartParameters' => $chartParameters,
            'total' => $total,
            'ikm' => $ikm,
            'jumlah' => $umpanBaliks['jumlah'],
        ]);
    }

    public function indexCustomer(Request $request)
    {
        $permohonanBaru = TitikPermohonan::whereYear('created_at', $request->tahun)->where('status', '<=', 1)->whereHas('permohonan', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->count();
        $permohonanDiproses = TitikPermohonan::whereYear('created_at', $request->tahun)->where(function ($q) {
            $q->where('status', '>=', 2);
            $q->where('status', '<=', 8);
        })->whereHas('permohonan', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->count();
        $permohonanSelesai = TitikPermohonan::whereYear('created_at', $request->tahun)->where('status', 9)->whereHas('permohonan', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->count();
        $permohonanTotal = TitikPermohonan::whereYear('created_at', $request->tahun)->whereHas('permohonan', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->count();

        $chartPermohonans = [
            'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'data' => [
                'baru' => [],
                'diproses' => [],
                'selesai' => [],
                'total' => [],
            ],
        ];
        for ($i = 1; $i <= 12; $i++) {
            $chartPermohonans['data']['baru'][$i - 1] = TitikPermohonan::whereMonth('created_at', $i)->whereYear('created_at', $request->tahun)->where('status', '<=', 1)->whereHas('permohonan', function ($q) {
                $q->where('user_id', auth()->user()->id);
            })->count();
            $chartPermohonans['data']['diproses'][$i - 1] = TitikPermohonan::whereMonth('created_at', $i)->whereYear('created_at', $request->tahun)->where(function ($q) {
                $q->where('status', '>=', 2);
                $q->where('status', '<=', 8);
            })->whereHas('permohonan', function ($q) {
                $q->where('user_id', auth()->user()->id);
            })->count();
            $chartPermohonans['data']['selesai'][$i - 1] = TitikPermohonan::whereMonth('created_at', $i)->whereYear('created_at', $request->tahun)->where('status', 9)->whereHas('permohonan', function ($q) {
                $q->where('user_id', auth()->user()->id);
            })->count();
            $chartPermohonans['data']['total'][$i - 1] = TitikPermohonan::whereMonth('created_at', $i)->whereYear('created_at', $request->tahun)->whereHas('permohonan', function ($q) {
                $q->where('user_id', auth()->user()->id);
            })->count();
        }

        return response()->json([
            'permohonanBaru' => $permohonanBaru,
            'permohonanDiproses' => $permohonanDiproses,
            'permohonanSelesai' => $permohonanSelesai,
            'permohonanTotal' => $permohonanTotal,
            'chartPermohonans' => $chartPermohonans,
        ]);
    }
}
