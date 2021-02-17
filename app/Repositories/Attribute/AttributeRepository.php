<?php

namespace App\Repositories\Attribute;

use App\Models\Attribute\Attribute;
use App\Repositories\BaseRepository;
use App\Library\QueryBuilder;
use App\Models\Attribute\AttributeOption;
use App\Sort\SortTranslateAttribute;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * Class AttributeRepository
 * @package App\Repositories\Attribute
 * @version August 25, 2020, 9:05 am UTC
 */

class AttributeRepository extends BaseRepository
{
    /**
     * Configure the Model
     **/
    public function model()
    {
        return Attribute::class;
    }
    public function allQuery($builder = null)
    {
        $allQuery = $this->setQueryBuilder($builder);
        $allQuery->allowedFields([
        ])
            ->allowedIncludes([
                'translations',
                'options','attributeGroup'
            ])
            ->allowedSorts([
                AllowedSort::custom('name', new SortTranslateAttribute(), 'name'),
            ])
            ->allowedFilters([
                AllowedFilter::callback('name', function ($query) use ($allQuery) {
                    $results = $query->whereHas('translations', function ($q) use ($allQuery) {
                        //thêm vào middleware trimstring để loại loại bỏ encode trên query mong muốn
                        $q->where('name', 'like', '%' . $allQuery->getRequest()->filters()->get('name') . '%');
                    });
                    return $results;
                }),
                AllowedFilter::callback('attribute_group_id', function ($query,$value) use ($allQuery) {
                    $results = $query->whereHas('attributeGroup', function ($q) use ($value) {
                        //thêm vào middleware trimstring để loại loại bỏ encode trên query mong muốn
                        $q->where('id', $value);
                    });
                    // dd($results);
                    return $results;
                }),
                //change locale by middleware
            ]);
        return $allQuery;
    }
    public function create($request)
    {
        $data = $request->all();
        $options = $request->only('attribute_value')['attribute_value'];
        // dd($options);
        $model = app()->make($this->model());
        foreach (core()->getAllLocales() as $locale) {
            foreach ($model->translatedAttributes as $attribute) {
                if (isset($data[$attribute])) {
                    $data[$locale->code][$attribute] = $data[$attribute];
                }
            }
        }



        $attributeModel = $this->model->create($data);
        foreach ($options as $option) {
            $optionModel = app()->make(AttributeOption::class);
            foreach (core()->getAllLocales() as $locale) {
                foreach ($optionModel->translatedAttributes as $attribute) {
                    if (isset($option[$attribute])) {
                        $option[$locale->code][$attribute] = $option[$attribute];
                    }
                }
                $option['attribute_id'] =  $attributeModel->id;
            }
            $optionModel->create($option);
        }
        return $attributeModel;
    }
}
