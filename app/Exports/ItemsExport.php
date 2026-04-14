<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ItemsExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    public function collection()
    {
        return Item::with('category')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Item Name',
            'Category',
            'Stock',
            'Created At'
        ];
    }

    public function map($item): array
    {
        return [
            $item->id,
            $item->name,
            $item->category->name ?? '-', // relasi category
            $item->stock,
            $item->created_at->format('d-m-Y')
        ];
    }
}