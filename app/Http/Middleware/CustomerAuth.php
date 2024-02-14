<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

class CustomerAuth 
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $auth_token = $request->bearerToken();
        if(!$auth_token) {
            return response()->json(['status'=> false, 'message' => 'Please Check Authentication Token'],400);
        }
        $auth_token = base64_decode($auth_token);
        $license_details = explode(':',$auth_token);
        
        $request->request->add(['user' => $license_details[0], 'project' => $license_details[1]]);
        
        return $next($request);
    }
}