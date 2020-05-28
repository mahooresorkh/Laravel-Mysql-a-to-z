<?php

namespace App\Http\Middleware;

use Closure;

class checkheader
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
        if($request->header('X-CSRF-TOKEN')){
            return $next($request);
        }
        
        return redirect('/illegal-address');
    }
}
