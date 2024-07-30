<?php

namespace App\Excel;

use App\Helpers\AppHelper;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class RegistrasiSampelExcel extends ReportExcel
{
    private $spreadsheet;
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
        $this->view();
    }

    public function view()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

        $row = 1;

        $sheet->getColumnDimension('A')->setWidth(6);
        $sheet->getColumnDimension('B')->setWidth(18);
        $sheet->getColumnDimension('C')->setWidth(18);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(30);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(10);
        $sheet->getColumnDimension('I')->setWidth(18);
        $sheet->getColumnDimension('J')->setWidth(12);
        $sheet->getColumnDimension('K')->setWidth(40);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(50);

        $sheet->setCellValue('A' . $row, 1);
        $sheet->setCellValue('B' . $row, 2);
        $sheet->setCellValue('C' . $row, 3);
        $sheet->setCellValue('D' . $row, 4);
        $sheet->setCellValue('E' . $row, 5);
        $sheet->setCellValue('F' . $row, 6);
        $sheet->setCellValue('G' . $row, 7);
        $sheet->setCellValue('H' . $row, 8);
        $sheet->setCellValue('I' . $row, 9);
        $sheet->setCellValue('J' . $row, 10);
        $sheet->setCellValue('K' . $row, 11);
        $sheet->setCellValue('L' . $row, 12);
        $sheet->setCellValue('M' . $row, 13);

        $sheet->getStyle('A' . $row . ':' . 'M' . $row)->applyFromArray($this->fontBold);
        $sheet->getStyle('A' . $row . ':' . 'M' . $row)->applyFromArray($this->centerMiddle);
        $sheet->getStyle('A' . $row . ':' . 'M' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('f3f1ff');
        $sheet->getStyle('A' . $row . ':' . 'M' . $row)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $row++;

        $sheet->getStyle('A' . $row . ':' . 'M' . $row)->applyFromArray($this->fontBold);
        $sheet->getStyle('A' . $row . ':' . 'M' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('fff9f1');
        $sheet->getStyle('A' . $row . ':' . 'M' . $row)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $row++;

        $sheet->setCellValue('A' . $row, 'No');
        $sheet->setCellValue('B' . $row, 'Tanggal Masuk');
        $sheet->setCellValue('C' . $row, 'Tanggal Selesai');
        $sheet->setCellValue('D' . $row, 'Customer');
        $sheet->setCellValue('E' . $row, 'Alamat');
        $sheet->setCellValue('F' . $row, 'Lokasi');
        $sheet->setCellValue('G' . $row, 'Titik Sampling');
        $sheet->setCellValue('H' . $row, 'Jam Tiba');
        $sheet->setCellValue('I' . $row, 'Jenis Sampel');
        $sheet->setCellValue('J' . $row, 'Volume Sampel');
        $sheet->setCellValue('K' . $row, 'Parameter');
        $sheet->setCellValue('L' . $row, 'Kode Lab');
        $sheet->setCellValue('M' . $row, 'Peraturan');

        $sheet->getRowDimension($row)->setRowHeight(30);

        $sheet->getStyle('A' . $row . ':' . 'M' . $row)->applyFromArray($this->fontBold);
        $sheet->getStyle('A' . $row . ':' . 'M' . $row)->applyFromArray($this->centerMiddle);
        $sheet->getStyle('A' . $row . ':' . 'M' . $row)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('eee2d3');
        $sheet->getStyle('A' . $row . ':' . 'M' . $row)
            ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        $row++;
        $no = 1;
        foreach ($this->data as $key => $value) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $value->tanggal_diterima);
            $sheet->setCellValue('C' . $row, $value->tanggal_selesai);
            $sheet->setCellValue('D' . $row, $value->permohonan->user->nama);
            $sheet->setCellValue('E' . $row, $value->permohonan->user->detail->alamat);
            $sheet->setCellValue('F' . $row, $value->permohonan->alamat);
            $sheet->setCellValue('G' . $row, $value->lokasi);
            $sheet->setCellValue('H' . $row, $value->jam_datang_uji);
            $sheet->setCellValue('I' . $row, @$value->jenisSampel->nama);
            $sheet->setCellValue('J' . $row, '');
            $sheet->setCellValue('K' . $row, $value->parameters->pluck('nama')->implode(', '));
            $sheet->setCellValue('L' . $row, $value->kode);
            $sheet->setCellValue('M' . $row, $value->peraturan ? ($value->peraturan->nama . ' ' . $value->peraturan->kode) : '');

            $sheet->getStyle('A' . $row . ':' . 'M' . $row)
                ->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $row++;
        }

        $sheet->setAutoFilter('A1:M' . $row);

        $this->spreadsheet = $spreadsheet;
    }

    public function download($filename = "")
    {
        $writer = new Xlsx($this->spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '.xlsx"');
        $writer->save("php://output");
    }
}
