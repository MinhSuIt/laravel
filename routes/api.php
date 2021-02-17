<?php

use App\Http\Controllers\API\Cart\CartAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');

});
Route::group([
    // 'middleware' => 'auth:api',
], function ($router) {
Route::group(['prefix' => 'category'], function () {
    Route::resource('categories', 'Category\CategoryAPIController')->only('show','index');
});


Route::group(['prefix' => 'product'], function () {
    Route::resource('products', 'Product\ProductAPIController')->only('show','index');
});


Route::group(['prefix' => 'core'], function () {
    Route::resource('locales', 'Core\LocaleAPIController')->only('show','index');
});


Route::group(['prefix' => 'attribute'], function () {
    Route::resource('attribute_groups', 'Attribute\AttributeGroupAPIController')->only('show','index');
});


Route::group(['prefix' => 'attribute'], function () {
    Route::resource('attributes', 'Attribute\AttributeAPIController')->only('show','index');
});


Route::group(['prefix' => 'core'], function () {
    Route::resource('currencies', 'Core\CurrencyAPIController')->only('show','index');
});


Route::group(['prefix' => 'cart'], function () {
    Route::post('add/{productId}','Cart\CartAPIController@add');
    Route::put('update','Cart\CartAPIController@update');
    Route::put('setCouponCode','Cart\CartAPIController@setCouponCode');
    Route::put('removeCouponCode','Cart\CartAPIController@removeCouponCode');
    Route::get('/','Cart\CartAPIController@index');
    Route::delete('/delete','Cart\CartAPIController@destroy');
});

Route::group(['prefix' => 'order'], function () {
    Route::get('/','Order\OrderAPIController@order');
});

});