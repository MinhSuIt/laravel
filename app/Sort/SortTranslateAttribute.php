<?php
namespace App\Sort;

use Illuminate\Database\Eloquent\Builder;

class SortTranslateAttribute implements \Spatie\QueryBuilder\Sorts\Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        return $query->OrderByTranslation($property, $descending ? 'desc' : 'asc');
    }
}