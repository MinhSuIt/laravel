<?php

namespace App\Exports;

use App\Library\QueryBuilder;
use App\Models\Category\Category;
use App\Models\Core\Locale;
use App\Repositories\Category\CategoryRepository;
use Astrotomic\Translatable\Locales;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class CategoryExport extends BaseExport
{
    public function repository()
    {
        return CategoryRepository::class;
    }
    public function map($category):array
    {
        // dd($category);
        $result = $this->baseMap($category);

        if (isset($category->attributeGroups)) {
            array_push($result, implode(" ", $category->attributeGroups->pluck('id')->toArray()));
        }
        // dd($result);

        return $result;
    }
    public function headings(): array
    {
        $result = $this->baseHeadings();
        return array_merge($result,[
            'attributeGroups'
        ]);
    }
}
