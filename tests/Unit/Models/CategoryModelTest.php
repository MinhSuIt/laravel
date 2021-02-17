<?php

namespace Tests\Unit\Models;

use App\Models\Category\Category;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\CreatesApplication;
use Tests\TestCase;

class CategoryModelTest extends TestCase
{
    use  WithFaker
    // ,RefreshDatabase
    ;

    protected $cateogry;
    
    // protected function setUp():void
    // {
    //     $this->category = factory(Category::class)->create();
    // }
    /** @test */
    public function test_products_relationship()
    {
        $cat = factory(Category::class)->create();
        $pro = factory(Product::class)->create();
        dd($cat);
        $cat->products()->sync([$pro->id]);

        $this->assertInstanceOf(BelongsToMany::class, $cat->products());
        $this->assertInstanceOf(Product::class, $cat->products->first());
    }
    /** @test */
    public function test_status_scope(): void
    {
        factory(Category::class)->create([
            'status' => false
        ]);

        // $this->assertInstanceOf(Builder::class, resolve(Category::class)->status(false));
        $this->assertInstanceOf(Builder::class, Category::status(false));
        $this->assertCount(1,Category::status(false)->get());
    }
    // public function categories_has_columns()
    // {
    //     $this->assertTrue( 
    //         Schema::hasColumns('categories', [
    //             'id', 'position', 'image','status','created_at','updated_at' 					
    //         ])
    //     );
    //     $this->assertTrue( 
    //         Schema::hasColumns('category_translations', [
    //            'name', 'slug','description','meta_title','meta_description','meta_keywords','category_id','locale'
    //       ]));
    // }
    /**
     * @test
     */
    // public function category_belongs_to_many_products()
    // {
    //     //thêm file env.testing 
    //     $this->assertInstanceOf(Collection::class, $this->category->products); 
    // }
}
