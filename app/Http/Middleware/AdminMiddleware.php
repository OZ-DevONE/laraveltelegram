<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; //Врубаем Auth
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        //Если юзер не авторизиррован и юзер не админ иди на главню страницу
        if (!Auth::check() || !Auth::user()->is_admin) {
            return redirect('/');
        }

        return $next($request);
    }
}
