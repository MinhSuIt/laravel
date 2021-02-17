<?php

use App\Helper\ImageHelper;
use App\Http\Controllers\Core\Core;
use App\Models\Core\Locale;
use Astrotomic\Translatable\Locales;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

if (!function_exists('core')) {
    function core()
    {
        return app()->make(Core::class);
    }
}
if (!function_exists('exchangePriceToDefaultCurrency')) {
    function exchangePriceToDefaultCurrency($price)
    {
        $result = currency($price, currency()->getUserCurrency(), config('currency.default'), false);
        return round($result, 2);
    }
}
if (!function_exists('getThumbImage')) {
    function getThumbImage($linkImage)
    {
        return app()->make(ImageHelper::class)->getImage($linkImage);
    }
}
if (!function_exists('getAllLanguageCode')) {
    function getAllLanguageCode()
    {
        return Cache::rememberForever('languages', function () {
            return Locale::all()->pluck('code');
        });
    }
}
if (!function_exists('addLanguageFromDBToRequest')) {
    function addLanguageFromDBToRequest()
    {
        $additionLocales = getAllLanguageCode();
        $localeInstance  = app()->make(Locales::class);
        foreach ($additionLocales as $value) {
            $localeInstance->add($value);
        }
    }
}

// if(!function_exists('uploadImagePublic')){
//     function uploadImagePublic($disk,$image,$name){
//         return Storage::putFileAs($disk, $image,$name);
//     }
// }

// if(!function_exists('deleteImagePublic')){
//     function deleteImagePublic($disk,$name){
//         Storage::disk($disk)->delete($name);
//     }
// }
// if (function_exists('route') && !function_exists('customRoute')) {
    
//     function customRoute($name, $parameters = [], $absolute = true)
//     {
//         $defaults = [];
//         if( session('language') !== null ){
//             $defaults['language'] = session('language');
//         }
//         if(session('currency') !== null ){
//             $defaults['currency'] = session('currency');
//         }
//         $result= array_merge($defaults,$parameters);
//         // dd($result);
//         return route($name,$result, $absolute);
//     }
// }

//
// if (!function_exists('sortRoute') && function_exists('route')) {
    
//     function sortRoute($routeName, $queryString, $value, $absolute = true) // index,sort,-name,true
//     {
//         $oldQuery = request()->query();  
//         if (request()->has($queryString)) { //có queryString
//             $posOfQueryString = strripos($oldQuery[$queryString],$value);

//             if( $posOfQueryString == null ){ //ko nằm trong giá trị của queryString
//                 if(strlen($oldQuery[$queryString]) >0){
//                     $oldQuery[$queryString] .= ",$value";
//                 }else{
//                     $oldQuery[$queryString] .= "$value";
//                 }
//             }else{
//                 //here
//                 if($posOfQueryString === 0 ){
//                     $oldQuery[$queryString] =str_replace("$value,","", $oldQuery[$queryString]);
//                 }
//                 else{
//                     $oldQuery[$queryString] =str_replace(",$value","", $oldQuery[$queryString]);
//                 }
//             }
//         }else{
//             return route($routeName, array_merge($oldQuery,[$queryString=>$value]), $absolute);
//         }
//     }
// }
