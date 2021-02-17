<?php

namespace App\Repositories;

use App\Library\QueryBuilder;
use App\User;
use App\Repositories\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
*/

class UserRepository extends BaseRepository
{


    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }
    public function allQuery($builder =null)
    {
        $allQuery = $this->setQueryBuilder($builder);;

        $allQuery->allowedFields([
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
            ])
            ->allowedIncludes([
                'roles'
            ]);
        return $allQuery;
    }

}
