<?php

namespace App\Exports;

use App\Repositories\Product\ProductRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExportCopy extends BaseExport
{
    public function repository()
    {
        return ProductRepository::class;
    }
    public function map($product):array
    {
        $result = $this->baseMap($product);
        if (isset($product->categories)) {
            array_push($result, implode(" ", $product->categories->pluck('id')->toArray()));
        }
        if (isset($product->attributes)) {
            array_push($result, implode(" ", $product->attributes->pluck('id')->toArray()));
        }
        // dd($result);
        return $result;
    }
    public function headings():array
    {
        $result = $this->baseHeadings();
        // dd($result, 123);
        return array_merge($result,[
            'categories','attributes'
        ]);
    }
}
