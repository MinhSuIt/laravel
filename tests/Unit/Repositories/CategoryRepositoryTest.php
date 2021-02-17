<?php

namespace Tests\Unit\Repositories;

use App\Helper\ImageHelper;
use App\Models\Category\Category;
use App\Repositories\Category\CategoryRepository;
use CategorySeeder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    //chưa test create

    // use RefreshDatabase;
    protected $categoryRepository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->categoryRepository = app()->make(CategoryRepository::class);
    }
    // protected function tearDown(): void
    // {

    // }

    /**
     * test
     *
     */
    public function testGetModelOfCategoryRepository()
    {
        $data = $this->categoryRepository->getModel();
        $this->assertInstanceOf(Category::class, $data);
    }

    /** @test */
    public function test_all_category_repository()
    {
        resolve(Category::class);
        $this->seed(CategorySeeder::class);
        $data = $this->categoryRepository->all();

        $this->assertInstanceOf(Category::class, $data[0]);
    }
    /** @test */

    public function test_paginate_category_repository()
    {
        $this->seed(CategorySeeder::class);
        $data = $this->categoryRepository->paginate(1);
        $this->assertInstanceOf(LengthAwarePaginator::class, $data);
        $this->assertObjectHasAttribute('total', $data);
        $this->assertObjectHasAttribute('lastPage', $data);
        $this->assertObjectHasAttribute('items', $data);
        $this->assertObjectHasAttribute('perPage', $data);
        $this->assertObjectHasAttribute('currentPage', $data);
        // $this->assertInstanceOf(Collection::class, $data->items);
        $this->assertInstanceOf(Category::class, $data[0]);
    }
    /** @test */
    public function test_create_category_repository()
    {
        // https://laracasts.com/series/whats-new-in-laravel-5-8/episodes/4 cụ thể
        // https://adamwathan.me/2016/10/12/replacing-mocks-with-spies/
        addLanguageFromDBToRequest();
        $file = UploadedFile::fake()->image('avatar.jpg');
        // stub:chưa viết gì cả,mock/spy đã viết nhưng chưa biết chạy đúng ko
        //mock là ko quan tâm instance of ImageHelper code gì bên trong
        //mà sẽ mình sẽ tự cho input và output (tự quyết định yêu cầu chức năng của instance đó)
        // $helper = $this->mock(ImageHelper::class, function ($mock) {
        //     //lần 1 gọi upload method, ->with() nếu cần truyền tham số đầu vào ,lần thứ ? trả về ? times(số)
        //     $mock->shouldReceive('upload')->once()->andReturn('');
        //     //lần 2 gọi upload method
        //     $mock->shouldReceive('upload')->twice()->andReturn('abc');
        // });
        // $a = $helper->upload(Category::IMAGE_DIR, $file->getRealPath(), Category::IMAGE_WIDTH, Category::IMAGE_HEIGHT, Category::IMAGE_DIR);
        // $b = $helper->upload(Category::IMAGE_DIR, $file->getRealPath(), Category::IMAGE_WIDTH, Category::IMAGE_HEIGHT, Category::IMAGE_DIR);
        // $c = $helper->upload(Category::IMAGE_DIR, $file->getRealPath(), Category::IMAGE_WIDTH, Category::IMAGE_HEIGHT, Category::IMAGE_DIR);
        // dd($a,$b,$c);


        // $helper = $this->partialMock(ImageHelper::class, function ($mock) {
        //     //lần 1 gọi upload method
        //     $mock->shouldReceive('upload')->once()->andReturn('');
        //     //lần 2 gọi upload method
        //     $mock->shouldReceive('upload')->twice()->andReturn('abc');
        // });
        // $a = $helper->upload(Category::IMAGE_DIR, $file->getRealPath(), Category::IMAGE_WIDTH, Category::IMAGE_HEIGHT, Category::IMAGE_DIR);
        // $b = $helper->upload(Category::IMAGE_DIR, $file->getRealPath(), Category::IMAGE_WIDTH, Category::IMAGE_HEIGHT, Category::IMAGE_DIR);
        // $c = $helper->upload(Category::IMAGE_DIR, $file->getRealPath(), Category::IMAGE_WIDTH, Category::IMAGE_HEIGHT, Category::IMAGE_DIR);
        // dd($a,$b,$c,$helper->getImage($b));


        //khác biệt giữa mock và mockPartial là sau khi mock class đc mock sẽ chỉ gọi đc những method khai báo trong callback
        //còn mockPartial cho phép có thể gọi như mock + có thể gọi các method khác của class chạy thực tế bình thường

        //spy là mock + ghi lại tương tác khi chạy, cho phép assert sau khi mã chạy

        // $helper = $this->spy(CategoryRepository::class);
        // Artisan::call('test:command');
        // $helper->shouldHaveReceived('testCommand');//khẳng định function testCommand đã đc chạy

        //mock là khai báo và thiết lập method sẵn rồi mới chạy cái cần test, rồi khẳng định
        //spy là khai báo rồi chạy cái cần test rồi thiết lập method,khẳng định

        $data = [
            'fromUrl' => $file->getRealPath(),
            "position" => "0",
            "status" => "1",
            "attributeGroups" => [1, 2],
            "vi" => [
                "name" => "ádsađâsd",
                "slug" => "ádsađâsd",
                "description" => "ádsađâsd",
                "meta_title" => "ádsađâsd",
                "meta_description" => "ádsađâsd",
                "meta_keywords" => "ádsađâsd",
            ],
            "en" => [
                "name" => "ádsađâsd",
                "slug" => "ádsađâsd",
                "description" => "ádsađâsd",
                "meta_title" => "ádsađâsd",
                "meta_description" => "ádsađâsd",
                "meta_keywords" => "ádsađâsd",
            ],
        ];

        $category = $this->categoryRepository->create($data);

        $category->load('translations', 'attributeGroups');

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals($data['position'], $category->position);
        $this->assertEquals($data['status'], $category->status);
        $this->assertEquals($data['attributeGroups'], $category->attributeGroups->pluck('id')->toArray());
        if ($category->image) {
            Storage::disk('public')->assertExists($category->image);
        } else {
            $this->assertEquals('', $category->image);
        }
        $this->assertEquals('vi', $category->getTranslation('vi')->locale);
        $this->assertEquals('en', $category->getTranslation('en')->locale);
        $vi = collect($category->getTranslation('vi')->toArray())->forget(['id', 'category_id', 'locale'])->toArray();
        $en = collect($category->getTranslation('en')->toArray())->forget(['id', 'category_id', 'locale'])->toArray();
        $this->assertEquals($data['vi'], $vi);
        $this->assertEquals($data['en'], $en);
    }
    public function testTestProtected()
    {
        $this->assertEquals($this->invokeMethod($this->categoryRepository, 'testProtected', array('123')), '123');
    }
    

}
