<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AsetTemplateExport implements FromArray, WithHeadings, ShouldAutoSize, WithStyles
{
    public function array(): array
    {
        return [
            [
                '1',
                'PERALATAN DAN MESIN',
                '3010204002',
                '1',
                'Laptop',
                'Asus',
                'Vivobook',
                'Laptop Asus Vivobook',
                '2023-01-15',
                '15000000',
                'Ruang Server',
                '6',
                '2024-01-01',
            ],
            [
                '2',
                'PERALATAN DAN MESIN',
                '3010204003',
                '2',
                'Printer',
                'Epson',
                'L3110',
                'Printer Ruang Rapat',
                '2024-02-10',
                '2500000',
                'Ruang Rapat',
                '',
                '',
            ],
            [
                '3',
                'ALAT ANGKUTAN BERMOTOR',
                '3.1.02.01.01.03',
                '3',
                'Mobil Kijang',
                '',
                '',
                '',
                '1998-08-20',
                '140450000',
                'Garasi',
                '3',
                '2024-05-15',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Jenis BMN',
            'Kode Barang',
            'NUP',
            'Nama Barang',
            'Merk',
            'Tipe',
            'Nama',
            'Tanggal Perolehan',
            'Nilai Perolehan Pertama',
            'Ruangan',
            'Interval Servis (Bulan)',
            'Tanggal Servis Terakhir',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF059669'], // emerald-600
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            'A1:M4' => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ]
        ];
    }
}
