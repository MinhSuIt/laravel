<?php

namespace App\Http\Middleware;

use Closure;

class CurrencyMiddleware
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
        if($request->has('currency')){
            session()->put('currency', $request->currency);
            
            currency()->setUserCurrency(session('currency'));
            $request->merge(['currency'=>session('currency')]);
        }
        if($request->session()->has('currency')){
            currency()->setUserCurrency(session('currency'));
            $request->merge(['currency'=>session('currency')]);
        }

        return $next($request);
    }
}
