<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $etat): Response
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }

        $authUserRole = Auth::user()->etat;

        switch($etat){
            case 'admin':
                if($authUserRole ==0){
                    return $next($request);

                }
                break;
            case 'utilisateur':
                if($authUserRole ==1){
                    return $next($request);

                }
                break;

            case 'autres':
                if($authUserRole ==2){
                    return $next($request);

                }
                break;

        }
        switch($authUserRole){
            case 0:
                return redirect()->route('dashboard');
            case 1:
                return redirect()->route('autres');
            case 2:
                return redirect()->route('autres');
        }
        return redirect()->route('login');

    }
}
