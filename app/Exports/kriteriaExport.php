<?php

namespace App\Exports;

use App\Models\Kriteria;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class kriteriaExport implements FromCollection, WithEvents, WithStyles, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Kriteria::all();
    }

    public function map($kriteria): array
    {
        return ['', $kriteria->kode, $kriteria->nama, $kriteria->bobot, $kriteria->jenis];
    }

    public function styles(Worksheet $sheet)
    {
        // Mengatur gaya header
        $sheet->getStyle('A2:E2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['argb' => 'FFCCFFCC'],
            ],
        ]);

        // Mengatur gaya teks tambahan
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 12,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Mengatur lebar kolom
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(25); // Lebar kolom untuk gambar
        $sheet->getColumnDimension('E')->setWidth(40); // Lebar kolom untuk informasi ekskul

        return $sheet;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Menambahkan teks di atas header
                $today = date('d-m-Y');
                $sheet->mergeCells('A1:E1');
                $sheet->setCellValue('A1', 'Dokumen di download pada tanggal ' . $today);
                $sheet
                    ->getStyle('A1')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // Menambahkan header di baris 2
                $sheet->setCellValue('A2', 'Nomor');
                $sheet->setCellValue('B2', 'Kode Kriteria');
                $sheet->setCellValue('C2', 'Nama Kriteria');
                $sheet->setCellValue('D2', 'Bobot');
                $sheet->setCellValue('E2', 'Jenis');

                // Mengatur gaya header
                $sheet->getStyle('A2:E2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 12,
                    ],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['argb' => 'FFCCFFCC'],
                    ],
                ]);

                // Menyimpan data di lembar kerja
                $kriteria = Kriteria::all();
                foreach ($kriteria as $key => $value) {
                    $row = $key + 3; // Mulai dari baris 3, setelah teks tambahan dan header
                    $sheet->setCellValue('A' . $row, $key + 1);
                    $sheet->setCellValue('B' . $row, $value->kode);
                    $sheet->setCellValue('C' . $row, $value->nama);
                    $sheet->setCellValue('D' . $row, $value->bobot);
                    $sheet->setCellValue('E' . $row, $value->jenis);
                }
                // Mengatur teks agar ditengah di kolom "A:C"
                $sheet
                    ->getStyle('A:E')
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);
                $sheet
                    ->getStyle('A:E')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
