<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class siswaExport implements FromCollection, WithEvents, WithStyles, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::where('role', 'Siswa')->get();
    }

    public function map($siswa): array
    {
        return ['', $siswa->nis, $siswa->nama, $siswa->gender, $siswa->kelas, $siswa->jenjang];
    }

    public function styles(Worksheet $sheet)
    {
        // Mengatur gaya header
        $sheet->getStyle('A2:F2')->applyFromArray([
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
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);

        $sheet
            ->getStyle('A:F')
            ->getAlignment()
            ->setVertical(Alignment::VERTICAL_CENTER);
        $sheet
            ->getStyle('A:F')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        $sheet
            ->getStyle('A1')
            ->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        // Mengatur gaya header
        $sheet->getStyle('A2:F2')->applyFromArray([
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

        return $sheet;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Menambahkan teks di atas header
                $today = date('d-m-Y');
                $sheet->mergeCells('A1:F1');
                $sheet->setCellValue('A1', 'Dokumen di download pada tanggal ' . $today);

                // Menambahkan header di baris 2
                $sheet->setCellValue('A2', 'Nomor');
                $sheet->setCellValue('B2', 'NIS');
                $sheet->setCellValue('C2', 'Nama Siswa');
                $sheet->setCellValue('D2', 'Jenis Kelamin');
                $sheet->setCellValue('E2', 'Kelas');
                $sheet->setCellValue('F2', 'Jenjang');

                // Menyimpan data di lembar kerja
                $siswa = User::where('role', 'Siswa')->get();
                foreach ($siswa as $key => $value) {
                    $row = $key + 3; // Mulai dari baris 3, setelah teks tambahan dan header
                    $sheet->setCellValue('A' . $row, $key + 1);
                    $sheet->setCellValue('B' . $row, $value->nis);
                    $sheet->setCellValue('C' . $row, $value->nama);
                    $sheet->setCellValue('D' . $row, $value->gender);
                    $sheet->setCellValue('E' . $row, $value->kelas);
                    $sheet->setCellValue('F' . $row, $value->jenjang);
                }
            },
        ];
    }
}
