<?php

namespace App\Repositories;

use App\Exceptions\NotBeInstanceOfModelException;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use App\Library\QueryBuilderCustom as QueryBuilder;

abstract class BaseRepository
{
    protected $model;

    protected $queryBuilder;

    protected function setExport()
    {
        return false;
    }
    protected function setImport()
    {
        return false;
    }

    public function __construct()
    {
        //sử dụng các phép this->A = B; trong 1 function rồi gọi function để dễ test,chi tiết trong makeModel()
        $this->makeModel();
    }

    //Thêm kiểu trả về,nếu viết code chuẩn sẽ dễ viết test hơn
    abstract public function model();
    // public function setQueryBuilder($builder = null)
    protected function setQueryBuilder($builder = false)
    {
        // dd($builder);
        if (!$builder)
            $builder = $this->model();
        $this->queryBuilder = QueryBuilder::for($builder);
        return $this->queryBuilder;
    }
    public function getQueryBuilder()
    {
        return $this->queryBuilder;
    }
    public function getModel()
    {
        return $this->model;
    }

    public function makeModel() //tạo đối tượng từ class
    {
        $model = app()->make($this->model());

        if (!$model instanceof Model) {
            //xem laravel query builder
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        return $this->model = $model;
    }


    public function paginate($perPage = 10)
    {
        $query = $this->allQuery();

        $data = $query->paginate($perPage);
        return $data;
    }


    abstract protected function allQuery($builder = null);

    public function all()
    {
        $query = $this->allQuery();

        return $query->get();
    }

    public function create($input)
    {
        $model = $this->model->create($input);

        return $model;
    }

    public function find($id)
    {
        $query = $this->allQuery($this->model()::where('id', $id))->first();
        return $query;
    }
    public function findById($id, $columns = ['*'])
    {
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }
    public function getAll(array $column = ['*'], $hasTranslation = true)
    {
        if ($hasTranslation) {
            return $this->model()::with('translations')->get();
        }
        return $this->model()::get();
    }

    public function update($model, $input)
    {

        $model = $model->fill($input);

        $model->save();

        return $model;
    }

    public function export()
    {
        if ($export = $this->setExport()) {
            $name = now();
            return Excel::download(app()->make($export), "$name.xlsx");
        }
        return;
    }
    public function import()
    {
        if ($import = $this->import()) {
            return Excel::import(new $import($this), request()->file('fileexcel'));
        }
        return;
    }

    //sử dụng cho các method model dạng :$model->function() như delete/restore/forceDelete 
    public function __call($methodName, $argv)
    {
        // dd($argv[0],$methodName);
        if (!$argv[0] instanceof Model) {

            throw new \Exception("First param must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }
        // $rc = new ReflectionClass($this->model()::class); //ko làm đc     
        return $argv[0]->$methodName();
    }
    protected function abv($a = null)
    {
        return $a;
    }
}
