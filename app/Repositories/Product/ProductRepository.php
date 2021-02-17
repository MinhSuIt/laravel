<?php

namespace App\Repositories\Product;

use App\Helper\ImageHelper;
use App\Jobs\UploadRelatedProductImage;
use App\Library\QueryBuilder;
use App\Models\Product\Product;
use App\Models\Product\ProductImage;
use App\Repositories\BaseRepository;
use App\Sort\SortTranslateAttribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\Filters\Filter;

class ProductRepository extends BaseRepository
{
    public function __construct(ImageHelper $imageHelper)
    {
        parent::__construct();
        $this->imageHelper = $imageHelper;
    }
    
    public function model()
    {
        return Product::class;
    }

    public function allQuery($builder = null)
    {
        $allQuery = $this->setQueryBuilder($builder);
        $allQuery
            ->allowedFields([
                // 'products.id',
                // 'id',
                // 'sku',
                // 'amount',
                // 'price',
                // 'image',
                // 'translations.name',
                // 'translations.description',
                // 'categories.id',
                // 'categories.translations.name'
            ])
            ->allowedIncludes([
                'translations',
                'media',
                'categories',
                'attributes',
                'attributeOptions'
            ])
            ->allowedSorts([
                'position',
                'status',
                'price',
                'products_count', //với include count : productsCount
                AllowedSort::custom('name', new SortTranslateAttribute(), 'name'),
                //có thể sort theo tên category bằng cách add field = model->category->name
            ])
            //include trước filter
            ->allowedFilters([
                AllowedFilter::trashed(),
                AllowedFilter::exact('id'),
                // 'sku',
                AllowedFilter::callback('name', function (Builder $query, $value, $property) use ($allQuery) {
                    $results = $query->whereHas('translations', function ($q) use ($value, $property) {
                        //thêm vào middleware trimstring để loại loại bỏ encode trên query mong muốn
                        // $allQuery->getRequest()->filters()->get('name')
                        $q->where('locale', app()->getLocale())->where($property, 'like', '%' . $value . '%');
                    });
                    return $results;
                }),
                AllowedFilter::callback('sku', function ($query) use ($allQuery) {
                    $results = ($query->where('sku', 'like', '%' . $allQuery->getRequest()->filters()->get('sku') . '%')->get());
                    return $results;
                }),

                AllowedFilter::callback('category_id', function ($query) use ($allQuery) {
                    $results = $query->whereHas('categories', function ($q) use ($allQuery) {

                        //thêm vào middleware trimstring để loại loại bỏ encode trên query mong muốn
                        $q->where('category_id', $allQuery->getRequest()->filters()->get('category_id'));
                    });
                    // dd($results);
                    return $results;
                }),

                AllowedFilter::callback('attribute_id', function ($query) use ($allQuery) {
                    $results = $query->whereHas('attributes', function ($q) use ($allQuery) {
                        $q->where('attribute_id', $allQuery->getRequest()->filters()->get('attribute_id'));
                    });
                    return $results;
                }),
                AllowedFilter::callback('price', function ($query, $value, $property) use ($allQuery) {
                    return $query->where('price', $allQuery->getRequest()->query->get('conditionPrice'), $value);
                }),
            ]);


        return $allQuery;
    }
    public function setPrice($price)
    {
        return currency($price, currency()->getUserCurrency(), config('currency.default'), false);
    }
    public function create($data)
    {
        $ContentImage = [];
        foreach (core()->getAllLocales() as $locale) {
            foreach ($this->model->translatedAttributes as $attribute) {
                // if (isset($data[$attribute])) {
                    // $data[$locale->code][$attribute] = $data[$attribute];
                    if ($attribute == 'content') {
                        $results = $this->model->setAttributeValueFromHTMLAndUpload('yyy', 120, 120, $data[$locale->code][$attribute], 'img', 'src');
                        $data[$locale->code][$attribute] = $results['dom'];
                        $ContentImage = $results['ContentImage'];
                    }
                // }
            }
        }
        // dd($data);
        //upload image
        if (isset($data['fromUrl'])) {
            //ko xài queue vì bắt buộc tên ảnh là đầu vào của $data['image]
            $link = $this->imageHelper->upload($this->model()::IMAGE_DIR, $data['fromUrl'], $this->model()::IMAGE_WIDTH, $this->model()::IMAGE_HEIGHT);
            $data['image'] = $link;
        }

        $data['price'] = $this->setPrice($data['price']);


        $product = $this->model->create($data);
        foreach ($ContentImage as $link) {
            $product->addMediaFromUrl(asset($this->imageHelper->getImage($link)))->toMediaCollection($this->model()::CONTENT_IMAGE_COLLECTION);
        }

        //upload relate image 
        if (isset($data['urlListOfImages'])) {
            foreach ($data['urlListOfImages'] as $imageUrl) {
                // dispatch(new UploadRelatedProductImage($product,$this->model()::IMAGE_DIR, $imageUrl, $this->model()::IMAGE_WIDTH, $this->model()::IMAGE_HEIGHT))->onQueue('relatedProductImage');
                //ko xài queue đc vì hình ảnh upload chỉ ở dạng temp sẽ ko đọc đc,muốn dùng queue phải upload ảnh lên rồi resize ảnh
                $linktemp = $this->imageHelper->upload($this->model()::IMAGE_DIR, $imageUrl, $this->model()::IMAGE_WIDTH, $this->model()::IMAGE_HEIGHT);
                $product->addMediaFromUrl(asset($this->imageHelper->getImage($linktemp)))->toMediaCollection($this->model()::SLIDE_IMAGE_COLLECTION);
            }
        }


        if (isset($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }
        // if (isset($data['attributes'])) {
        //     $product->categories()->sync($data['attributes']);
        // }

        return $product;
    }
    public function deleteProductImages($productImages)
    {
        foreach ($productImages as $productImage) {
            $this->imageHelper->delete($productImage->image, ProductImage::IMAGE_DISK);
            $productImage->delete();
        }
    }
    public function update($product,$data)
    {
        $ContentImage = [];
        foreach (core()->getAllLocales() as $locale) {
            foreach ($this->model->translatedAttributes as $attribute) {
                // if (isset($data[$attribute])) {
                    // $data[$locale->code][$attribute] = $data[$attribute];
                    if ($attribute == 'content') {
                        $results = $this->model->setAttributeValueFromHTMLAndUpload('yyy', 120, 120, $data[$locale->code][$attribute], 'img', 'src');
                        $data[$locale->code][$attribute] = $results['dom'];
                        $ContentImage = $results['ContentImage'];
                    }
                // }
            }
        }
        // dd($data);
        //upload image
        if (isset($data['fromUrl'])) {
            //ko xài queue vì bắt buộc tên ảnh là đầu vào của $data['image]
            $this->imageHelper->delete($product->image);
            $link = $this->imageHelper->upload($this->model()::IMAGE_DIR, $data['fromUrl'], $this->model()::IMAGE_WIDTH, $this->model()::IMAGE_HEIGHT);
            $data['image'] = $link;
        }

        $data['price'] = $this->setPrice($data['price']);


        $this->model->update($data);
        if(!collect($ContentImage)->isEmpty()){
            $product->clearMediaCollection($this->model()::CONTENT_IMAGE_COLLECTION);
            foreach ($ContentImage as $link) {
                $product->addMediaFromUrl(asset($this->imageHelper->getImage($link)))->toMediaCollection($this->model()::CONTENT_IMAGE_COLLECTION);
            }
        }

        

        //upload relate image 
        if (isset($data['urlListOfImages'])) {
            foreach ($data['urlListOfImages'] as $imageUrl) {
                // dispatch(new UploadRelatedProductImage($product,$this->model()::IMAGE_DIR, $imageUrl, $this->model()::IMAGE_WIDTH, $this->model()::IMAGE_HEIGHT))->onQueue('relatedProductImage');
                //ko xài queue đc vì hình ảnh upload chỉ ở dạng temp sẽ ko đọc đc,muốn dùng queue phải upload ảnh lên rồi resize ảnh
                $linktemp = $this->imageHelper->upload($this->model()::IMAGE_DIR, $imageUrl, $this->model()::IMAGE_WIDTH, $this->model()::IMAGE_HEIGHT);
                $product->addMediaFromUrl(asset($this->imageHelper->getImage($linktemp)))->toMediaCollection($this->model()::$SLIDE_IMAGE_COLLECTION);
            }
        }


        if (isset($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }
        // if (isset($data['attributes'])) {
        //     $product->categories()->sync($data['attributes']);
        // }

        return $product;
    }
    public function delete($product)
    {
        $this->imageHelper->delete($product->image, $this->model()::IMAGE_DISK);

        $oldImages = $product->images()->get();
        $this->deleteProductImages($oldImages);
        $product->images()->delete();

        $product->delete();
    }
}
