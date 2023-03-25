<?php

namespace App\Exports;

use App\AbsensiKaryawan;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportAbsensi implements FromView, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = Carbon::parse($startDate);
        $this->endDate = Carbon::parse($endDate)->addDay();
    }

    public function view(): View
    {
        $data = AbsensiKaryawan::with(['user.department'])
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();

        return view('export.absensi', [
            'data' => $data
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'FF9900',
                ],
            ],
        ]);

        $sheet->getStyle($sheet->calculateWorksheetDimension())->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
    }
}
