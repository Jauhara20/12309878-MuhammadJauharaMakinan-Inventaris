<?php

namespace App\Exports;

use App\Models\Lending;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\AfterSheet;

class LendingsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithCustomStartCell
{
    public function collection()
    {
        return Lending::with(['item', 'returnedBy'])->get();
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Item',
            'Borrower',
            'Total',
            'Keterangan',
            'Created At',
            'Returned At',
            'Returned By',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->setCellValue('A1', 'Laporan Peminjaman');
                $sheet->mergeCells('A1:H1');
                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->getHeaderFooter()->setOddHeader('&LHalaman &P');
            },
        ];
    }

    public function map($lending): array
    {
        return [
            $lending->id,
            $lending->item->name ?? '-',
            $lending->name,
            $lending->total,
            $lending->keterangan ?? '-',
            $lending->created_at ? $lending->created_at->format('d-m-Y H:i') : '-',
            $lending->returned_at ? $lending->returned_at->format('d-m-Y H:i') : 'Not Returned',
            $lending->returnedBy->name ?? '-',
        ];
    }
}
