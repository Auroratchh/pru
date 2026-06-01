<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class isAdminMiddleware
{

    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            if(Auth::user()->eliminado == 0){
                if(Auth::user()->idRol == 1 || Auth::user()->idRol == 3 ){
                    return $next($request);
                }
                else
                {
                    return redirect('/');
                }
            }
            else{
                Auth::logout();
                $request->session()->flush();
                $request->session()->regenerate();

                $mensaje = "Acceso Denegado. Usuario eliminado.";
                return redirect('error/'.$mensaje);
            }
        }
        else{
            return redirect('/');
        }

    }
}
