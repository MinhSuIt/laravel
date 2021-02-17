<?php

namespace Tests\Unit\Repositories;

use App\Exceptions\NotBeInstanceOfModelException;
use App\Library\QueryBuilderCustom;
use App\Models\Category\Category;
use App\Repositories\BaseRepository;
use App\Repositories\Category\CategoryRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Mockery\MockInterface;
use Tests\Eloquent\ABC;
use Tests\TestCase;

class BaseRepositoryTest extends TestCase
{
    /** 
     * @test
     *  */
    public function testBaseRepositoryConstruct()
    {
        $repository = app()->make(CategoryRepository::class);
        $this->assertInstanceOf(Model::class, $repository->getModel());
    }


    /** 
     * @test
     *  */
    public function testBaseRepositoryMakeModel(): Model
    {
        //xem kĩ đầu vào của getMockForAbstractClass truyền vào cho đúng
        $stub = $this->getMockForAbstractClass(BaseRepository::class, [], '', false);
        $stub->expects($this->once()) //this->any/twice... số lần gọi
            ->method('model')
            ->will($this->returnValue(Category::class));
        $instance = $stub->makeModel();
        $this->assertInstanceOf(Category::class, $instance);
        return $instance;
    }
    /** 
     * @test
     *  */
    public function testBaseRepositoryMakeModelFail()
    {
        $stub = $this->getMockForAbstractClass(BaseRepository::class, [], '', false);
        $stub->expects($this->any())
            ->method('model')
            ->will($this->returnValue(ABC::class));

        $this->expectException(\Exception::class);
        $instance = $stub->makeModel();

        //test thử trong model() của categoryRepository
    }
    /** 
     * @test
     * @depends testBaseRepositoryMakeModel
     */
    public function testGetModel($instance)
    {
        $this->assertInstanceOf(Category::class, $instance);
    }
    /** @test */
    public function testSetQueryBuilder()
    {
        $mock = $this->getMockForAbstractClass(BaseRepository::class, [], '', false);
        $builder = app()->make(Builder::class);
        $this->assertInstanceOf(QueryBuilderCustom::class, $this->invokeMethod($mock, 'setQueryBuilder', array($builder)));
        // $this->assertInstanceOf(QueryBuilderCustom::class, $this->invokeMethod($mock, 'setQueryBuilder',[false]) ); chưa check đc false
        return $this->invokeMethod($mock, 'setQueryBuilder', array($builder));
    }
    /** 
     * @test
     * @depends testSetQueryBuilder
     *  */
    public function testGetQueryBuilder($builder)
    {
        $this->assertInstanceOf(QueryBuilderCustom::class, $builder);
    }
    //test các method create,update bằng cách tạo eloquent/model với fillable
}
