<?php

namespace App\Repositories\Attribute;

use App\Library\QueryBuilder;
use App\Models\Attribute\AttributeGroup;
use App\Repositories\BaseRepository;
use App\Sort\SortTranslateAttribute;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * Class AttributeGroupRepository
 * @package App\Repositories\Attribute
 * @version August 25, 2020, 9:01 am UTC
*/

class AttributeGroupRepository extends BaseRepository
{

    /**
     * Configure the Model
     **/
    public function model()
    {
        return AttributeGroup::class;
    }
    public function allQuery($builder = null)
    {
        $allQuery = $this->setQueryBuilder($builder);

        $allQuery->allowedFields([
            // 'position',
            // 'image',
            // 'status',
            // 'category_translations.name',
            // 'category_translations.description',
            // 'category_translations.meta_title',
            // 'category_translations.meta_description',
            // 'category_translations.meta_keywords',
        ])
            ->allowedIncludes([
                'translations',
                'attributes.options',
                'categories',
            ])
            ->allowedSorts([
                'position',
                'status',
                'price',
                'products_count', //với include count : productsCount
                AllowedSort::custom('name', new SortTranslateAttribute(),'name'),
            ])
            ->allowedFilters([
                AllowedFilter::callback('name', function ($query,$value,$property) use ($allQuery) {
                    $results = $query->whereHas('translations', function ($q) use ($value) {
                        //thêm vào middleware trimstring để loại loại bỏ encode trên query mong muốn
                        $q->where('locale',app()->getLocale())->where('name', 'like', '%' . $value . '%');
                    });
                    return $results;
                }),
                //change locale by middleware
            ]);
        return $allQuery;
    }
    public function create($request)
    {
        $data = $request->all();
        $model = app()->make($this->model());
        foreach (core()->getAllLocales() as $locale) {
            foreach ($model->translatedAttributes as $attribute) {
                if (isset($data[$attribute])) {
                    $data[$locale->code][$attribute] = $data[$attribute];
                }
            }
        }
        $attributeGroup = $this->model->create($data);

        if (isset($data['category_ids'])) {
            $attributeGroup->categories()->sync($data['category_ids']);
        }
        return $attributeGroup;
    }

}
