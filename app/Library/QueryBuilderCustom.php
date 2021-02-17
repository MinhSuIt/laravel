<?php
namespace App\Library;

use Spatie\QueryBuilder\QueryBuilder;

class QueryBuilderCustom extends QueryBuilder {
    function getRequest(){
        return $this->request;
    }
}
