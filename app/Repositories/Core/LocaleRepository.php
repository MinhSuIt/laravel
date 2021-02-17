<?php

namespace App\Repositories\Core;

use App\Library\QueryBuilder;
use App\Models\Core\Locale;
use App\Repositories\BaseRepository;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Class LocaleRepository
 * @package App\Repositories\Core
 * @version August 19, 2020, 12:26 pm UTC
*/

class LocaleRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Locale::class;
    }
    public function allQuery($builder = null){
        $allQuery = $this->setQueryBuilder($builder);;
        $allQuery->allowedFields([
            'code',
            'name',
            'direction'
        ])
            ->allowedFilters([
                'name',
                AllowedFilter::exact('code'),
                //change locale by middleware
            ])
            ->allowedIncludes([
                'translations'
            ]);
        return $allQuery;
    }
}
