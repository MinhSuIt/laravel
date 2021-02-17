<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


abstract class BaseImport implements ToModel, WithHeadingRow,WithValidation
{
    protected $repository;
    protected $locales;
    protected $headings;
    protected $fillables;
    protected $translatedAttributes;

    public function __construct($repository)
    {
        // $this->setRepository();
        $this->repository = $repository;
        $this->locales = getAllLanguageCode(); 
        $this->fillables = $this->repository->getModel()->getFillable();
        $this->translatedAttributes = $this->repository->getModel()->translatedAttributes;
    }
    
    abstract public function rules(): array;
    abstract public function repository();
    abstract public function dataOfRow($row) : array;
    // protected function setRepository()
    // {
    //     $this->repository = app()->make($this->repository());
    // }

    public function model(array $row)
    {
        //có thể dùng queue ở đây sau
        return $this->repository->create($this->dataOfRow($row));
    }

    //bao gồm các trường bảng chính và bảng translation
    public function baseData($row):array
    {
        $result = [];
        foreach ($this->fillables as $fillable) {
            $result[$fillable] =  $row[$fillable];
        }
        if(!collect($this->translatedAttributes)->isEmpty()){
            foreach ($this->locales as $locale) {
                $dataLocale = [];
                foreach ($this->translatedAttributes as $translatedAttribute) {
                    $dataLocale[$translatedAttribute] = $row[$translatedAttribute . '_' . $locale];
                }
                $result[$locale]= $dataLocale;
            }
        }
        return $result;
    }
}
