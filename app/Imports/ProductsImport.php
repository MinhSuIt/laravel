<?php

namespace App\Imports;

use App\Repositories\Product\ProductRepository;

class ProductsImport extends BaseImport
{
    public function repository()
    {
        return ProductRepository::class;
    }
    public function rules(): array
    {
        return [];
    }
    public function dataOfRow($row):array
    {
        // $result = $this->baseData($row);
        // $result['fromUrl'] = $row['image'];
        // //chữ hoa bị đổi thành chữ thường nên đặt key là chữ thường : attributeGroups =>attributegroups
        // if(isset($row['categories'])){
        //     $result['attributeGroups'] = explode(" ", $row['attributegroups']);
        // }
        // if(isset($row['attributes'])){
        //     $result['attributeGroups'] = explode(" ", $row['attributegroups']);
        // }
        // // dd($result);
        // return $result;
    }
}
