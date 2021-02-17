<?php

namespace Tests\Unit\Controller;

use App\Http\Controllers\Category\CategoryController;
use App\Models\Category\Category;
use App\Repositories\Attribute\AttributeGroupRepository;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Pagination\LengthAwarePaginator;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use WithoutMiddleware;
    protected function setUp(): void
    {
        parent::setUp();
        // sử dụng mock cho repository của construct
        $repo1= $this->mock(CategoryRepository::class, function ($mock) {
            $mock->shouldReceive('create')->with([])->once()->andReturn('abc');
        });
        $repo2= $this->mock(AttributeGroupRepository::class, function ($mock) {
            $mock->shouldReceive('getAll')->once()->andReturn('bcd');
        });

        $this->categoryController =  app()->make(CategoryController::class,[$repo1,$repo2]);
        dd(123);
        // $this->withoutMiddleware('permission:' . request()->route()->getName()); // bỏ 1 miđleware cụ thể
        // dd($this->categoryController->categoryRepository->create());

    }
    /**
     * @test
     */
    public function test_category_controller_index()
    {
        // $response = $this->get('/category/categories?include=attributeGroups,productsCount&fields[categories]=id,position,image,status');
        $category = factory(Category::class)->create();
        $this->get(route('category.categories.index'))
            ->assertSee('Categories');

        // $response->assertStatus(200);
        // $results = factory(Category::class,4)->make();
        // $this->categoryRepositiory->shouldReceive('paginate')
        //     ->andReturn(collect([]))
        //     ->once();

        // $res = $this->controller->index();
        // $this->assertViewIs('category.categories.index');
    }
}
