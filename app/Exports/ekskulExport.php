<?php

namespace App\Exports;

use App\Models\Ekstrakurikuler;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ekskulExport implements FromCollection, WithDrawings, WithStyles, WithEvents, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Ekstrakurikuler::all();
    }

    public function map($ekskul): array
    {
        $informasiEkskul = trim($ekskul->informasi_ekskul);
        $informasiEkskul = str_replace(["\n", "\r"], '', $informasiEkskul);
        return [
            $ekskul->id,
            $ekskul->kode_ekskul,
            $ekskul->nama_ekskul,
            '', // Placeholder untuk gambar
            $informasiEkskul,
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $ekskul = Ekstrakurikuler::all();

        foreach ($ekskul as $key => $value) {
            if ($value->image) {
                $drawing = new Drawing();
                $drawing->setName('Gambar Ekskul');
                $drawing->setDescription('Gambar Ekskul');
                $drawing->setPath(public_path('/dist/assets/img/ekskul/' . $value->image));
                $drawing->setHeight(80); // Set tinggi gambar
                $row = $key + 3; // Mulai dari baris 3, setelah teks tambahan dan header

                // Set koordinat gambar di kolom D
                $drawing->setCoordinates('D' . $row);
                $drawing->setOffsetX(10); // Sesuaikan offset X
                $drawing->setOffsetY(10); // Sesuaikan offset Y

                $drawings[] = $drawing; // Menambahkan drawing ke array
            }
        }

        return $drawings;
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

        // Mengatur tinggi baris
        $rowCount = Ekstrakurikuler::count() + 2; // +2 untuk header dan teks tambahan
        for ($row = 3; $row <= $rowCount; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(80); // Set tinggi baris
        }

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
                $sheet->setCellValue('B2', 'Kode Ekskul');
                $sheet->setCellValue('C2', 'Nama Ekskul');
                $sheet->setCellValue('D2', 'Image');
                $sheet->setCellValue('E2', 'Informasi Ekskul');

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
                $ekskul = Ekstrakurikuler::all();
                foreach ($ekskul as $key => $value) {
                    $informasiEkskul = trim($value->informasi_ekskul);
                    $informasiEkskul = str_replace(["\n", "\r"], '', $informasiEkskul);
                    $row = $key + 3; // Mulai dari baris 3, setelah teks tambahan dan header
                    $sheet->setCellValue('A' . $row, $key + 1);
                    $sheet->setCellValue('B' . $row, $value->kode_ekskul);
                    $sheet->setCellValue('C' . $row, $value->nama_ekskul);
                    $sheet->setCellValue('D' . $row, '');
                    $sheet->setCellValue('E' . $row, $informasiEkskul);
                }

                // Mengatur teks agar wrap di kolom "Informasi Ekskul"
                $sheet->getStyle('E')->getAlignment()->setWrapText(true);
                $sheet
                    ->getStyle('E')
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);
                $sheet
                    ->getStyle('E')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT);

                // Mengatur teks agar ditengah di kolom "A:C"
                $sheet
                    ->getStyle('A:C')
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);
                $sheet
                    ->getStyle('A:C')
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
