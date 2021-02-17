<?php

namespace Tests\Unit\Models;

use App\Models\Category\Category;
use App\Models\Product\Product;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tests\TestCase;

class ProductModelTest extends TestCase
{
    /** @test */
    public function test_categories_relationship()
    {
        $cat = factory(Category::class)->create();
        $pro = factory(Product::class)->create();

        $pro->categories()->sync($cat);

        $this->assertInstanceOf(BelongsToMany::class, $pro->categories());
        $this->assertInstanceOf(Category::class, $pro->categories->first());
    }
}
