<?php

namespace App\Repositories\Authorization;

use App\Library\QueryBuilder;
use App\Models\Authorization\Permission;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * Class PermissionRepository
 * @package App\Repositories\Authorization
 * @version September 10, 2020, 3:10 pm UTC
 */

class PermissionRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Permission::class;
    }
    public function allQuery($builder =null)
    {
        $allQuery = $this->setQueryBuilder($builder);

        $allQuery->allowedFields([
        ])
            ->allowedIncludes([
                'roles',
            ])
            ->allowedSorts([
                'name',
                'role_id',
            ])
            //include trước filter
            ->allowedFilters([
                AllowedFilter::exact('id'),
                'name',
                AllowedFilter::callback('role_id', function ($query,$value,$property) {
                    $results = $query->whereHas('roles', function ($q)use($value) {

                        //thêm vào middleware trimstring để loại loại bỏ encode trên query mong muốn
                        $q->where('role_id', $value);
                    });
                    return $results;
                }),
            ]);
        return $allQuery;
    }
}
