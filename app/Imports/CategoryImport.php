<?php

namespace App\Imports;

use App\Repositories\Category\CategoryRepository;

class CategoryImport extends BaseImport
{
    public function repository()
    {
        return CategoryRepository::class;
    }
    public function rules(): array
    {
        return [];
        // return $this->repository->getModel()->getAddRules();
    }
    public function dataOfRow($row):array
    {
        $result = $this->baseData($row);
        $result['fromUrl'] = $row['image'];
        //chữ hoa bị đổi thành chữ thường nên đặt key là chữ thường : attributeGroups =>attributegroups
        if(isset($row['attributegroups'])){
            $result['attributeGroups'] = explode(" ", $row['attributegroups']);
        }
        // dd($result);
        return $result;
    }
}

