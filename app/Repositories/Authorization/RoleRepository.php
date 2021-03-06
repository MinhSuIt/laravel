<?php

namespace App\Repositories\Authorization;

use App\Library\QueryBuilder;
use App\Models\Authorization\Role;
use App\Repositories\BaseRepository;

/**
 * Class RoleRepository
 * @package App\Repositories\Authorization
 * @version September 10, 2020, 4:00 pm UTC
*/

class RoleRepository extends BaseRepository
{

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Role::class;
    }
    public function allQuery($builder = null)
    {
        $allQuery = $this->setQueryBuilder($builder);

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
        //             });
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
