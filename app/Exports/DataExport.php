<?php

namespace App\Exports;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
/* use Maatwebsite\Excel\Concerns\WithMapping; */
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class DataExport implements FromCollection, /* WithMapping, */ WithHeadings, /* WithDrawings, */ ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $export;

    public function __construct($export) {
        $this->export = $export;
    }

    public function collection() {
        return $this->export["rows"];
    }

    /* Si lo pongo como FromModel, me obligan a exportar un modelo exactamente de Laravel, es decir, no puedo cambiar los valores ni nada porque para eso tendría que armar una colección, por eso meor exporto como FromCollection porque de esta forma puedo exportar los datos ya tratados, en una nueva colleción, porque no puedo cambiar los valores de un modelo, es decir, no podría sustituir las relaciones */

    /* public function map($product): array {
        
        $item = [];
        $columns = Schema::getColumnListing('products');

        foreach ($columns as $column) {
            $item[$column] = $product->$column;
            if ($column == "category") $item[$column] = $product->categoryinfo->name;
            if ($column == "provider" && $product->provider != null) $item[$column] = $product->providerinfo->name;
            if ($column == "sell_type") $item[$column] = ($product->sell_type == 1) ? "Unidad" : (($product->sell_type == 2) ? "Peso" : "Metro");
            if ($column == "image") unset($item[$column]);
            if ($column == "created_at") $item[$column] = Date::dateTimeToExcel($product->created_at);      
            if ($column == "updated_at") $item[$column] = Date::dateTimeToExcel($product->updated_at);                          
        }

        return $item;
    } */

    public function headings(): array
    {
        return $this->export["headers"];
    }

    public static function getColumnLetter($num) {
        $numeric = ($num - 1) % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval(($num - 1) / 26);
        if ($num2 > 0) {
            return self::getColumnLetter($num2) . $letter;
        } else {
            return $letter;
        }
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $letter = self::getColumnLetter(count($this->export["headers"]));
                $headersRange = 'A1:'.$letter.'1'; // All headers
                $allBodyRange = 'A2:'.$letter.(count($this->export["rows"])+1); // All body
                $allCellsRange = 'A1:'.$letter.(count($this->export["rows"])+1); // All cells

                $styleHeaderArray = [
                    'font' => [
                        'bold' => true,
                        'color' => [
                            'argb' => 'FFFFFF',
                        ],
                        "size" => 13
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => [
                            'argb' => '2C3E50',
                        ]
                    ],
                ];

                $styleAllCellsArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ]
                    ],
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'wrap' => true,
                    ]
                ];

                $styleAllBodyArray = [
                    'font' => [
                        "size" => 10
                    ]
                ];

                $event->sheet->getStyle($headersRange)->applyFromArray($styleHeaderArray);
                $event->sheet->getStyle($allBodyRange)->applyFromArray($styleAllBodyArray);
                $event->sheet->getStyle($allCellsRange)->applyFromArray($styleAllCellsArray);
                $event->sheet->getDefaultRowDimension()->setRowHeight(25);
            },
        ];
    }

}
