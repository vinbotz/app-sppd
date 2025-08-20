<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SppdTerbaruExport implements FromView, WithStyles, ShouldAutoSize
{
    protected $sppdList;
    protected $columns;
    public function __construct($sppdList, $columns = [])
    {
        $this->sppdList = $sppdList;
        $this->columns = $columns;
    }
    public function view(): View
    {
        return view('admin.sppd.sppd-terbaru-excel', [
            'sppdList' => $this->sppdList,
            'columns' => $this->columns
        ]);
    }
    public function styles(Worksheet $sheet)
    {
        // Hitung jumlah kolom
        $colCount = count($this->columns) + 1; // +1 untuk kolom No
        $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colCount);
        $rowCount = count($this->sppdList) + 1; // +1 header
        $range = "A1:{$lastCol}{$rowCount}";
        return [
            // Header
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => false],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E3E6EA'],
                ],
            ],
            // Seluruh tabel
            $range => [
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => false],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
            ],
        ];
    }
} 