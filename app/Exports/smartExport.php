<?php

namespace App\Exports;

use App\Models\HasilSmart;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class smartExport implements FromCollection, WithMapping, WithHeadings, WithEvents, WithTitle
{
    private $row = 0;

    public function collection()
    {
        return HasilSmart::with('rEkstrakurikuler', 'rSiswa')->get();
    }

    public function map($hasilSmart): array
    {
        $this->row++;
        return [
            $this->row, // Nomor urut dimulai dari 1
            $hasilSmart->rSiswa->nis ?? 'N/A',
            $hasilSmart->rSiswa->nama ?? 'N/A',
            $hasilSmart->rSiswa->gender ?? 'N/A',
            $hasilSmart->rSiswa->kelas ?? 'N/A',
            $hasilSmart->rSiswa->jenjang ?? 'N/A',
            $hasilSmart->created_at->format('Y-m-d H:i:s'),
            $hasilSmart->hasil_smart,
            $hasilSmart->rEkstrakurikuler->nama_ekskul ?? 'N/A',
        ];
    }

    public function headings(): array
    {
        return [
            'Nomor',
            'NIS',
            'Nama Siswa',
            'Jenis Kelamin',
            'Kelas',
            'Jenjang',
            'Tanggal Proses',
            'Nilai SMART',
            'Rekomendasi Ekskul',
        ];
    }

    public function title(): string
    {
        return 'Hasil SMART';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Menambahkan baris kosong di awal
                $sheet->insertNewRowBefore(1, 1);

                // Styling untuk judul
                $sheet->mergeCells('A1:I1');
                $sheet->setCellValue('A1', 'Dokumen di download pada tanggal ' . date('d-m-Y'));
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Styling untuk header (sekarang di baris 3)
                $sheet->getStyle('A2:I2')->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'CCFFCC'],
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    ],
                ]);

                // Mengatur lebar kolom
                $sheet->getColumnDimension('A')->setWidth(10);
                $sheet->getColumnDimension('B')->setWidth(20);
                $sheet->getColumnDimension('C')->setWidth(30);
                $sheet->getColumnDimension('D')->setWidth(15);
                $sheet->getColumnDimension('E')->setWidth(10);
                $sheet->getColumnDimension('F')->setWidth(10);
                $sheet->getColumnDimension('G')->setWidth(20);
                $sheet->getColumnDimension('H')->setWidth(15);
                $sheet->getColumnDimension('I')->setWidth(25);

                // Mengatur alignment untuk semua sel
                $sheet->getStyle('A3:I' . $sheet->getHighestRow())
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            },
        ];
    }
}
