<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()) {
            // return redirect('/kasir');
            return $next($request);
        }
        
        //$user = Auth::user(); //model
        // if($user->level == 'admin') { //jika level user admin
        //     return $next($request);
        // }

        return redirect('/login');
        
    }
}
