<?php

namespace App\Exports;

use App\Models\Core\Locale;
use App\Repositories\Product\ProductRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

abstract class BaseExportCopy implements FromCollection, WithMapping, ShouldAutoSize, WithHeadings
{
    protected $repository;
    protected $fillables;
    protected $translatedAttributes;
    public function __construct()
    {
        $this->setRepository();
        $this->fillables = $this->repository->getModel()->getFillable();
        $this->translatedAttributes = $this->repository->getModel()->translatedAttributes;
    }
    abstract public function repository();
    abstract public function map($intance):array;
    abstract public function headings():array;

    public function setRepository()
    {
        $this->repository = app()->make($this->repository());
    }

    public function collection()
    {
        //lấy theo query string
        $results = $this->repository->all();
        return $results;
    }

    public function baseMap($intance)
    {
        $result = [];

        $translations = $intance->translations;

        foreach ($this->fillables as $fillable) {
            array_push($result, $intance->$fillable);
        }
        if ($translations) {
            foreach ($translations as $translation) {
                foreach ($this->translatedAttributes as $translatedAttributes) {
                    array_push($result, $translation->$translatedAttributes);
                }
            }
        }
        return $result;
    }

    //các trường fillable và translation
    public function baseHeadings()
    {
        $locales = Locale::all()->pluck('code');
        $fillables = $this->repository->getModel()->getFillable();
        $translatedAttributes = $this->repository->getModel()->translatedAttributes;
        $data = $fillables;

        foreach ($locales as $locale) {
            foreach ($translatedAttributes as $translatedAttribute) {
                array_push($data, $translatedAttribute . "_" . $locale);
            }
        }
        return $data;
    }


}
