<?php

namespace App\Repositories\Core;

use App\Library\QueryBuilder;
use App\Models\Core\Config;
use App\Repositories\BaseRepository;

/**
 * Class ConfigRepository
 * @package App\Repositories\Core
 * @version September 11, 2020, 2:39 pm UTC
*/

class ConfigRepository extends BaseRepository
{


    /**
     * Configure the Model
     **/
    public function model()
    {
        return Config::class;
    }
    public function allQuery($builder =null)
    {
        //sử dụng js để chuyển trang cho search
        $allQuery = $this->setQueryBuilder($builder);;

        // $allQuery->allowedFields([
        //     'position',
        //     'image',
        //     'status',
        //     'category_translations.name',
        //     'category_translations.description',
        //     'category_translations.meta_title',
        //     'category_translations.meta_description',
        //     'category_translations.meta_keywords',
        // ])
        //     ->allowedFilters([
        //         AllowedFilter::callback('name', function ($query) use ($allQuery) {
        //             $results = $query->whereHas('translations', function ($q) use ($allQuery) {
        //                 //thêm vào middleware trimstring để loại loại bỏ encode trên query mong muốn
        //                 $q->where('name', 'like', '%' . $allQuery->getRequest()->filters()->get('name') . '%');
        //             })->get();
        //             return $results;
        //         }),
        //         //change locale by middleware
        //     ])
        //     ->allowedIncludes([
        //         'translations'
        //     ]);
        return $allQuery;
    }
}
