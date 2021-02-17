<?php

namespace App\Http\Middleware;

use Closure;

class FilterQueryMiddleware
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
        $this->removeNullQueryFromRequest($request);
        return $next($request);
    }
    protected function removeNullQueryFromRequest($request)
    {
        $inputBag = collect($request->query)->whereNotNull();
        foreach ($inputBag as $key => $value) {
            if(is_array($value)){
                $value = collect($value)->whereNotNull()->toArray();
                $inputBag->put($key,$value);
            }
        }
        // dd(request()->query);
        $request->query->replace($inputBag->toArray());
        // dd($request->query);
    }
}
