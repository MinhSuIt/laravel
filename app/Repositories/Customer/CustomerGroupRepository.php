<?php

namespace App\Repositories\Customer;

use App\Library\QueryBuilder;
use App\Models\Customer\CustomerGroup;
use App\Repositories\BaseRepository;

/**
 * Class CustomerGroupRepository
 * @package App\Repositories\Customer
 * @version September 11, 2020, 2:56 pm UTC
*/

class CustomerGroupRepository extends BaseRepository
{

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CustomerGroup::class;
    }
    public function allQuery($builder =null)
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
        //upload image
        if ($request->hasFile('image') && $request->image->isValid()) {
            $name = (string)Str::uuid() . "." . $request->image->getClientOriginalExtension();
            uploadImagePublic('public', $request->image, $name);
            $data['image'] = $name;
        }
        $group = $this->model->create($data);
        // if (isset($data['attributes'])) {
        //     $category->filterableAttributes()->sync($data['attributes']);
        // }


        return $group;
    }
}
