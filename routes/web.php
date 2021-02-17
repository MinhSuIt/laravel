<?php

use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\HomeController;
use App\Models\Category\Category;
use App\Models\Core\Currency;
use App\Models\Product\Product;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Core\CurrencyRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth::routes();



// ->middleware(['verified','role:add'])
// $this->middleware('auth');



Auth::routes(['verify' => true]);
//verified

Route::get('/abc', 'HomeController@abc');
Route::get('/clearCache', 'HomeController@clearCache')->name('clearCache');
Route::post('/uploadByContentProduct', 'HomeController@upload')->name('uploadByContentProduct');

Route::middleware(['language', 'currency'])->group(function () {

    Route::get('/testCallMagicMethod', 'Category\CategoryController@forceDelete');

    Route::get('/', 'HomeController@index')->name('dashboard');

    Route::get('/test', 'HomeController@test')->name('test');

    Route::group(['prefix' => 'category'], function () {
        Route::resource('categories', 'Category\CategoryController', ["as" => 'category'])->except('show');
        Route::delete('categories/forceDelete/{id}', 'Category\CategoryController@forceDelete')->name('category.categories.forceDelete');
        Route::get('export', 'Category\CategoryController@export')->name('category.export');
        Route::post('import', 'Category\CategoryController@import')->name('category.import');
    });


    Route::group(['prefix' => 'product'], function () {
        Route::resource('products', 'Product\ProductController', ["as" => 'product'])->except('show');
        Route::delete('products/forceDelete/{id}', 'Product\ProductController@forceDelete')->name('product.products.forceDelete');
        Route::get('export', 'Product\ProductController@export')->name('product.export');
        Route::post('import', 'Product\ProductController@import')->name('product.import');
    });


    Route::group(['prefix' => 'core'], function () {
        Route::resource('locales', 'Core\LocaleController')->except('show');
        Route::resource('currencies', 'Core\CurrencyController');
        Route::resource('configs', 'Core\ConfigController')->except('show', 'create');
    });

    Route::group(['prefix' => 'attribute'], function () {
        Route::resource('attributeGroups', 'Attribute\AttributeGroupController')->except('show');
        Route::resource('attributes', 'Attribute\AttributeController')->except('show');
    });

    Route::resource('users', 'UserController')->middleware('auth');


    Route::group(['prefix' => 'authorization'], function () {
        Route::resource('permissions', 'Authorization\PermissionController', ["as" => 'authorization'])->only('create', 'index');
        Route::resource('roles', 'Authorization\RoleController')->except('show');
    });



    Route::group(['prefix' => 'customer'], function () {
        Route::resource('customers', 'Customer\CustomerController')->except('show');
        Route::resource('customerGroups', 'Customer\CustomerGroupController')->except('show');
    });


    Route::group(['prefix' => 'customer'], function () {
    });

    Route::group(['prefix' => 'coupon'], function () {
        Route::resource('cuopons', 'Coupon\CouponController', ["as" => 'coupon'])
            ->except('show');
    });
    Route::group(['prefix' => 'order'], function () {
        Route::resource('orders', 'Order\OrderController', ["as" => 'order'])->only('index', 'update');
        Route::post('changeStatus', 'Order\OrderController@changeStatus')->name('order.changeStatus');
    });

    // Route::resource('addresses', 'AddressController');
});
