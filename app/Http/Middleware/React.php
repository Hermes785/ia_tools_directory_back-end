<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class React
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token=$request->header('API_TOKEN');
        if(!$token){
            return response()->json(['message'=>'Missing token'],403);
        }
        $user= User::where('api_token',$token)->first();
        if(!$user){
            return response()->json(['message'=>'Invalid credentials'],403);
        }
        Auth::login($user);
        return $next($request);
    }
}
