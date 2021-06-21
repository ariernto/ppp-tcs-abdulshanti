<?php

namespace App\Http\Middleware;

use Closure;

class CheckApiKey
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
    if (config('app.apikey') != $request->input('_key'))
    { // if api key is not right
      return response()->json([
        "status" => 0,
        "msg" => "invalid api key"
      ]);
        }
        else 
        {
            return $next($request);
        }
  }
}
