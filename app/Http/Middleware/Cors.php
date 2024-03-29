<?php

namespace App\Http\Middleware;

use Closure;

class Cors
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
        $domains = ['http://localhost:8081','http://localhost'];
        if (isset($request->server()['HTTP_ORIGIN'])){
            $origin = $request->server()['HTTP_ORIGIN'];
            if(in_array($origin, $domains)){
                header("Acces-Control-Allow-Origin: .$origin");
                header("Acces-Control-Allow-Headers: Origin, Content-Type, Authorization");
            }
        }
        return $next($request);
    }
}
