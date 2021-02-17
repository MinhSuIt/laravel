<?php

namespace App\Providers;

use App\Http\Controllers\API\Cart\Cart;
use App\Models\Attribute\Attribute;
use App\Models\Attribute\AttributeGroup;
use App\Models\Authorization\Role;
use App\Models\Category\Category;
use App\Models\Category\CategoryTranslation ;
use App\Models\Core\Config;
use App\Models\Core\Currency;
use App\Models\Core\Locale;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerGroup;
use App\Models\Product\Product;
use App\Models\Product\ProductCategory;
use App\Models\Product\ProductImage;
use App\Observers\AttributeGroupObserver;
use App\Observers\AttributeObserver;
use App\Observers\CategoryObserver;
use App\Observers\ConfigObserver;
use App\Observers\CurrencyObserver;
use App\Observers\CustomerGroupObserver;
use App\Observers\CustomerObserver;
use App\Observers\LocalObserver;
use App\Observers\ProductCategoryObserver;
use App\Observers\ProductObserver;
use App\Observers\RoleObserver;
use App\Observers\UserObserver;
use App\Repositories\Cart\CartRepository;
use App\Repositories\Category\CategoryRepository;
use App\User;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        //dùng cách này hoặc khai báo trong config/app 
        $this->app->singleton('cart', function () {
            return new cart();
        });

        $this->app->bind('cart', Cart::class);
        //end cách


        if ($this->app->isLocal()) {

            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $languages = Locale::all();
        View::share('languages', $languages);
        $currencies = currency()->getCurrencies();
        View::share('currencies', $currencies);
        




        Category::observe(CategoryObserver::class);
        Product::observe(ProductObserver::class);
        Locale::observe(LocalObserver::class);
        AttributeGroup::observe(AttributeGroupObserver::class);
        Attribute::observe(AttributeObserver::class);
        Config::observe(ConfigObserver::class);
        // Currency::observe(CurrencyObserver::class); //tự viết event ko dùng observer
        Customer::observe(CustomerObserver::class);
        CustomerGroup::observe(CustomerGroupObserver::class);
        Role::observe(RoleObserver::class);
        User::observe(UserObserver::class);

        if(request()->input('filter.trashed') == 'only'){
            $isTrash = true;
        }else{
            $isTrash = false;
        }

        View::share('isTrash', $isTrash);
        
    }
}
class CartFacade extends Facade{
    protected static function getFacadeAccessor() { return 'cart'; }
}