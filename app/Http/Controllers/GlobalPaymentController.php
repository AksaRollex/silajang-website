<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelper;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GlobalPaymentController extends Controller
{
    public function index(Request $request)
    {
        if (request()->wantsJson()) {
            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page - 1 : 0);

            DB::statement('set @no=0+' . $page * $per);
            $data = Payment::where(function ($q) use ($request) {
                $q->where('va_number', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('nama', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('jumlah', 'LIKE', '%' . $request->search . '%');
                $q->orWhere('tanggal_exp', 'LIKE', '%' . $request->search . '%');
            })->when($request->status != '-', function ($q) use ($request) {
                $q->where('status', $request->status);
            })->orderBy('created_at', 'desc')->whereYear('created_at', $request->tahun)->paginate($per, ['*', DB::raw('@no := @no + 1 AS no')]);

            $data->map(function ($a) {
                $a->tanggal_dibuat = AppHelper::tanggal_indo(Carbon::parse($a->created_at)->format('Y-m-d'));

                if (isset($a->tanggal_exp)) {
                  $a->tanggal_exp_indo = AppHelper::tanggal_indo($a->tanggal_exp);
                } else if (isset($a->qris_expired)) {
                  $a->tanggal_exp_indo = AppHelper::tanggal_indo($a->qris_expired);
                }
            });

            return response()->json($data);
        } else {
            return abort(404);
        }
    }

    public function report(Request $request)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $payments = Payment::when($request->status != '-', function ($q) use ($request) {
            $q->where('status', $request->status);
        })->orderBy('created_at', 'desc')->whereYear('created_at', $request->tahun)->get();

        $sheet->setCellValue('A1', 'No.');
        $sheet->setCellValue('B1', 'Virtual Account');
        $sheet->setCellValue('C1', 'Atas Nama');
        $sheet->setCellValue('D1', 'Jumlah Nominal');
        $sheet->setCellValue('E1', 'Dibuat Pada');
        $sheet->setCellValue('F1', 'Tanggal Kedaluwarsa');
        $sheet->setCellValue('G1', 'Status');

        $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFE1B48F');
        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:G1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:G1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(25);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(25);

        $row = 2;
        foreach ($payments as $i => $payment) {
            $sheet->setCellValue('A' . $row, $i + 1);
            $sheet->setCellValue('B' . $row, (string)$payment->va_number);
            $sheet->setCellValue('C' . $row, $payment->nama);
            $sheet->setCellValue('D' . $row, AppHelper::tanggal_indo(Carbon::parse($payment->created_at)->format('Y-m-d')));
            $sheet->setCellValue('E' . $row, AppHelper::tanggal_indo($payment->tanggal_exp));
            $sheet->setCellValue('F' . $row, $payment->status);
            $sheet->setCellValue('G' . $row, $payment->jumlah);

            $sheet->getStyle('B' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);

            $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0.00');

            $row++;
        }

        $sheet->mergeCells('A' . $row . ':F' . $row);
        $sheet->setCellValue('A' . $row, 'Total');
        $sheet->setCellValue('G' . $row, '=SUM(G2:G' . ($row - 1) . ')');

        $sheet->getStyle('A' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('G' . $row)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('#,##0.00');
        $sheet->getStyle('A' . $row . ':G' . $row)->getFont()->setBold(true);

        $sheet->getStyle('A2:G' . $row)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="Laporan VA Pembayaran ' . $request->tahun . '.xlsx"');
        $writer->save("php://output");
    }
}
