<?php

namespace App\Http\Middleware;

use Closure;
use DB;
class TokenVerify
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
       $token = $request->access_token;
       $device_id = $request->device_id;
       $user_id = $request->uid;
       $users = DB::table('devices')->where('uid',$user_id)->where('access_token',$token)->where('device_id', $device_id)->first();
        if(isset($users)){
            return $next($request);
       }else {
        return response()->json([
            'status' => 2,
                'message' => 'Invalid token',
                'data' => []
          ]);
           
        }


       
       
    }
}
