<?php

namespace App\Exports;

use App\Models\ProductMovimentation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProductMovimentationExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }

    public function map($productMovimentation): array
    {
        return [
            $productMovimentation->id,
            $productMovimentation->quantity,
            $this->getType($productMovimentation->type),
            $this->getReason($productMovimentation->reason),
            $productMovimentation->proof,
            $productMovimentation->product->name,
            $productMovimentation->created_at
        ];
    }

    public function headings(): array
    {
        return [
            'Id',
            'Qtde',
            'Tipo',
            'Motivo',
            'Comprovante',
            'Produto',
            'Data',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'G' => NumberFormat::FORMAT_DATE_YYYYMMDD2,
        ];
    }

    private function getReason($reason)
    {
        return match ($reason) {
            'sell' => 'Venda',
            'buy' => 'Compra',
            'adjustment' => 'Ajuste',
            'transfer' => 'Transferência',
            default => 'Desconhecido',
        };
    }

    private function getType($type)
    {
        return match ($type) {
            'in' => 'Entrada',
            'out' => 'Saída',
            default => 'Desconhecido',
        };
    }
}
