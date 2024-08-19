<?php

namespace App\Http\Controllers;

use App\Models\KeteranganUmpanBalik;
use App\Models\UmpanBalik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class UmpanBalikController extends Controller
{
    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $this->checkExpired();

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = UmpanBalik::where(function ($q) use ($request) {
                $q->where('nomer', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('tahun', 'LIKE', '%' . $request->search . '%');
            })->where('bulan', $request->bulan)->where('tahun', $request->tahun)->orderBy('created_at', 'nomer')->paginate($per, ['titik_permohonans.*', DB::raw('@no := @no + 1 AS no')]);

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function summary(Request $request)
    {
        $data = UmpanBalik::select(DB::raw('SUM(u1)/COUNT(id) as u1'), DB::raw('SUM(u2)/COUNT(id) as u2'), DB::raw('SUM(u3)/COUNT(id) as u3'), DB::raw('SUM(u4)/COUNT(id) as u4'), DB::raw('SUM(u5)/COUNT(id) as u5'), DB::raw('SUM(u6)/COUNT(id) as u6'), DB::raw('SUM(u7)/COUNT(id) as u7'), DB::raw('SUM(u8)/COUNT(id) as u8'), DB::raw('SUM(u9)/COUNT(id) as u9'), DB::raw('COUNT(id) as jumlah'))->where('tahun', $request->tahun)->where('bulan', $request->bulan)->first();

        $data['u1'] = (float)$data['u1'];
        $data['u2'] = (float)$data['u2'];
        $data['u3'] = (float)$data['u3'];
        $data['u4'] = (float)$data['u4'];
        $data['u5'] = (float)$data['u5'];
        $data['u6'] = (float)$data['u6'];
        $data['u7'] = (float)$data['u7'];
        $data['u8'] = (float)$data['u8'];
        $data['u9'] = (float)$data['u9'];

        $total = 0;
        $ikm = 0;

        $total += ($data['u1']);
        $total += ($data['u2']);
        $total += ($data['u3']);
        $total += ($data['u4']);
        $total += ($data['u5']);
        $total += ($data['u6']);
        $total += ($data['u7']);
        $total += ($data['u8']);
        $total += ($data['u9']);

        $ikm = $total / 9;

        return response()->json([
            'data' => $data,
            'total' => $total,
            'ikm' => $ikm,
            'keterangan' => KeteranganUmpanBalik::get()
        ]);
    }

    public function resetSummary(Request $request){
        $data = UmpanBalik::where('tahun', $request->tahun)->where('bulan', $request->bulan);

        $data->delete();
        
        $total = 0;
        $ikm = 0;
        
        return response()->json([
            'data' => $data,
            'total' => $total,
            'ikm' => $ikm,
            'keterangan' => KeteranganUmpanBalik::get()
        ]);
    }

    public function templateImport()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $data = KeteranganUmpanBalik::all();
        $sheet->setCellValue('A1', 'U1');
        $sheet->setCellValue('B1', 'U2');
        $sheet->setCellValue('C1', 'U3');
        $sheet->setCellValue('D1', 'U4');
        $sheet->setCellValue('E1', 'U5');
        $sheet->setCellValue('F1', 'U6');
        $sheet->setCellValue('G1', 'U7');
        $sheet->setCellValue('H1', 'U8');
        $sheet->setCellValue('I1', 'U9');

        $sheet->setCellValue('A2', $data[0]->keterangan);
        $sheet->setCellValue('B2', $data[1]->keterangan);
        $sheet->setCellValue('C2', $data[2]->keterangan);
        $sheet->setCellValue('D2', $data[3]->keterangan);
        $sheet->setCellValue('E2', $data[4]->keterangan);
        $sheet->setCellValue('F2', $data[5]->keterangan);
        $sheet->setCellValue('G2', $data[6]->keterangan);
        $sheet->setCellValue('H2', $data[7]->keterangan);
        $sheet->setCellValue('I2', $data[8]->keterangan);

        $sheet->getStyle('A1:I1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFE1B48F');
        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:I1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:I1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

        $sheet->getStyle('A2:I2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFE1B48F');
        $sheet->getStyle('A2:I2')->getFont()->setBold(true);
        $sheet->getStyle('A2:I2')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

        $sheet->getColumnDimension('A')->setWidth(25);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(25);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);
        $sheet->getColumnDimension('H')->setWidth(25);
        $sheet->getColumnDimension('I')->setWidth(25);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Template Import Umpan Balik.xlsx"');
        $writer->save("php://output");
    }

    public function importData(Request $request)
    {
        $request->validate([
            'tahun' => 'required',
            'bulan' => 'required',
            'file' => 'required|mimes:xlsx,xls'
        ]);

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($request->file('file'));
        $sheet = $spreadsheet->getActiveSheet();

        for ($i = 3; $i <= $sheet->getHighestRow(); $i++) {
            $check = UmpanBalik::where('tahun', $request->tahun)->where('bulan', $request->bulan)->orderBy('nomer', 'desc')->first();
            if ($check) {
                $nomer = $check->nomer + 1;
            } else {
                $nomer = 1;
            }

            UmpanBalik::create([
                'nomer' => $nomer,
                'tahun' => $request->tahun,
                'bulan' => $request->bulan,
                'u1' => $sheet->getCell('A' . $i)->getValue() ?? 0,
                'u2' => $sheet->getCell('B' . $i)->getValue() ?? 0,
                'u3' => $sheet->getCell('C' . $i)->getValue() ?? 0,
                'u4' => $sheet->getCell('D' . $i)->getValue() ?? 0,
                'u5' => $sheet->getCell('E' . $i)->getValue() ?? 0,
                'u6' => $sheet->getCell('F' . $i)->getValue() ?? 0,
                'u7' => $sheet->getCell('G' . $i)->getValue() ?? 0,
                'u8' => $sheet->getCell('H' . $i)->getValue() ?? 0,
                'u9' => $sheet->getCell('I' . $i)->getValue() ?? 0,
            ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'u1' => 'required|numeric',
            'u2' => 'required|numeric',
            'u3' => 'required|numeric',
            'u4' => 'required|numeric',
            'u5' => 'required|numeric',
            'u6' => 'required|numeric',
            'u7' => 'required|numeric',
            'u8' => 'required|numeric',
            'u9' => 'required|numeric',
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->user()->id;
        $data['tahun'] = date('Y');
        $data['bulan'] = date('m');

        $umpanBalik = UmpanBalik::where('tahun', $data['tahun'])->where('bulan', $data['bulan'])->orderBy('nomer', 'desc')->first();
        $data['nomer'] = $umpanBalik ? $umpanBalik->nomer + 1 : 1;

        if (UmpanBalik::create($data)) {
            return response()->json([
                'status' => 'success'
            ]);
        } else {
            return abort(500);
        }
    }
}
