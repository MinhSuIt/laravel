<?php

namespace App\Repositories\Category;

use App\Exports\CategoryExport;
use App\Helper\ImageHelper;
use App\Imports\CategoryImport;
use App\Library\QueryBuilder;
use App\Models\Category\Category;
use App\Models\Core\Locale;
use App\Repositories\BaseRepository;
use App\Sort\SortTranslateAttribute;
use Error;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;
use Tests\Eloquent\ABC;

/**
 * Class CategoryRepository
 * @package App\Repositories\Category
 * @version August 14, 2020, 3:57 am UTC
 */

class CategoryRepository extends BaseRepository
{
    protected $imageHelper;
    public function __construct(ImageHelper $imageHelper)
    {
        parent::__construct();
        $this->imageHelper = $imageHelper;
    }
    public function model()
    {
        // return ABC::class;
        return Category::class;
    }

    public function setExport()
    {
        return CategoryExport::class;
    }
    public function setImport()
    {
        return CategoryImport::class;
    }
    protected function allQuery($builder = null)
    {
        //sử dụng js để chuyển trang cho search
        $allQuery = $this->setQueryBuilder($builder);
        // dd($allQuery->getRequest());
        $allQuery
            ->allowedFields([
                //tên bảng.tên fields
                'categories.id',
                'categories.position',
                'categories.image',
                'categories.status',
                // 'translations.name',
                // 'translations.id',
                // 'translations.description',
                // 'attributeGroups.id',
                // 'attributes.id',
                // 'categoryTranslations.meta_title',
                // 'categoryTranslations.meta_description',
                // 'categoryTranslations.meta_keywords',
            ])
            ->allowedIncludes([
                //translation tự load theo model
                'attributeGroups',
                AllowedInclude::count('productsCount'),
            ])
            ->allowedSorts([
                'position',
                'status',
                'products_count', //với include count : productsCount
                AllowedSort::custom('name', new SortTranslateAttribute(), 'name'),
            ])
            // ->defaultSort('-products_count')
            ->allowedFilters([
                AllowedFilter::trashed(),
                AllowedFilter::callback('name', function ($query) use ($allQuery) {
                    $results = $query->whereHas('translations', function ($q) use ($allQuery) {
                        //thêm vào middleware trimstring để loại loại bỏ encode trên query mong muốn
                        $q->where('locale', app()->getLocale())->where('name', 'like', '%' . $allQuery->getRequest()->filters()->get('name') . '%');
                    });
                    return $results;
                }),
                AllowedFilter::callback('attribute_group_id', function ($query, $value, $property) use ($allQuery) {
                    $results = $query->whereHas('attributeGroups', function ($q) use ($allQuery) {
                        $q->where('attribute_group_id', $allQuery->getRequest()->filters()->get('attribute_group_id'));
                    });
                    return $results;
                }),
                AllowedFilter::exact('id'),
                AllowedFilter::scope('status'),
                //change locale by middleware
            ]);
        return $allQuery;
    }

    public function create($data)
    {
        //có thể có or ko
        // foreach (core()->getAllLocales() as $locale) {
        //     foreach ($model->translatedAttributes as $attribute) {
        //         if (isset($data[$attribute])) {
        //             $data[$locale->code][$attribute] = $data[$attribute];
        //         }
        //     }
        // }
        // 
        // dd($data);


        if (isset($data['fromUrl'])) {
            //ko mock static method
            $link = $this->imageHelper->upload($this->model()::IMAGE_DIR, $data['fromUrl'], $this->model()::IMAGE_WIDTH, $this->model()::IMAGE_HEIGHT, $this->model()::IMAGE_DIR);
            $data['image'] = $link;
        } else {
            $data['image'] = '';
        }

        $category = parent::create($data);


        //chưa validate attributeGroups
        if (isset($data['attributeGroups'])) {
            $category->attributeGroups()->sync($data['attributeGroups']);
        }

        // dd($category);
        return $category;
    }
    public function update($category, $data)
    {
        if (isset($data['fromUrl'])) {
            $this->imageHelper->delete($category->image, Category::IMAGE_DIR);
            $link = $this->imageHelper->upload($this->model()::IMAGE_DIR, $data['fromUrl'], $this->model()::IMAGE_WIDTH, $this->model()::IMAGE_HEIGHT, $this->model()::IMAGE_DIR);
            $data['image'] = $link;
        }
        $category = parent::update($category, $data);
        if (isset($data['attributeGroups'])) {
            $category->attributeGroups()->sync($data['attributeGroups']);
        }
        return $category;
    }
    public function testCommand()
    {
        return 'abc';
    }
    protected function testProtected($a)
    {
        return $a;
    }
}
