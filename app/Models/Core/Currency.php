<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Torann\Currency\Currency as CurrencyCurrency;


class Currency extends CurrencyCurrency
//ko extends eloquent model nnên ko observer đc
{
    const COLLECTION_TAG = 'currencies';
    const CREATE_TAG = 'create-currency';
    const SHOW_TAG = 'show-currency';
    const EDIT_TAG = 'edit-currency';

    const COLLECTION_TAG_TIME = 'cacheResponse:300';
    const CREATE_TAG_TIME = 'cacheResponse:300';
    const SHOW_TAG_TIME = 'cacheResponse:300';
    const EDIT_TAG_TIME = 'cacheResponse:300';
    public static $rules = [
        'name'=>'required|unique:currencies','code'=>'required|unique:currencies','symbol'=>'required','format'=>'required','exchange_rate'=>'required','active'=>'required'
    ];
    public static function getAddRules()
    {
        return array_merge(
            self::$rules,[]
        );
    }
    public static function getEditRules($modelId)
    {
        return array_merge(
            self::$rules,[
                'name'=>'required|unique:currencies,code,'.$modelId,
                'code'=>'required|unique:currencies,code,'.$modelId
            ]
        );
    }
}
