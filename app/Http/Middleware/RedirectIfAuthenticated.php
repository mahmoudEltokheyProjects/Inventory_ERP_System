<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard)
        {
            if(Auth::guard($guard)->check())
            {
                // Redirect Both "FrontEnd" and "BackEnd(Admin)" When "User" is "Login"
                // if "Request" from "Admin guard" Then "Go To Backend"
                if ($request->is("admin") || $request->is("admin/*"))
                {
                    // return redirect(RouteServiceProvider::HOME);
                    // if [ Url = "admin/" ] or [ Url = "admin/WriteAnyThing" ] Then Redirect "Backend"
                    return redirect(RouteServiceProvider::ADMIN);

                }
                else
                {
                    // Else "Go To Our Website" [ Redirect To "FrontEnd" ] , Becaue Our Website does'nt contain "Frontend" Then Go to "Backend"
                    return redirect(RouteServiceProvider::ADMIN);

                }
            }
        }

        return $next($request);
    }
}
