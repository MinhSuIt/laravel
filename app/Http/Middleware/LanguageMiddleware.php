<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Core\Locale;
use Astrotomic\Translatable\Locales;
use Illuminate\Support\Facades\Cache;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('language')) {
            session(['language' => $request->language]);

            app()->setLocale(session('language'));
            $request->merge(['language' => session('language')]);
        }
        if ($request->session()->has('language')) {
            app()->setLocale(session('language'));
            $request->merge(['language' => session('language')]);
        }
        addLanguageFromDBToRequest();
        return $next($request);
    }
}
