<?php

namespace App\Repositories\Core;

use App\Library\QueryBuilder;
use App\Models\Core\Currency;
use App\Repositories\BaseRepository;
use Spatie\QueryBuilder\AllowedFilter;

/**
 * Class CurrencyRepository
 * @package App\Repositories\Core
 * @version August 26, 2020, 1:56 pm UTC
 */

class CurrencyRepository
{
    public function model()
    {
        return Currency::class;
    }
    public function all()
    {
        return currency()->getCurrencies();
    }

    public function create($input)
    {
        $model = currency()->create($input);
        return $model;
    }
    public function find($code)
    {   
        $currency = currency()->find($code);
        return $currency;
    }
    public function update($data,$currency)
    {
        return currency()->update($currency->code,$data);
    }
    public function delete($currency)
    {
        return currency()->delete($currency->code);
    }
}
