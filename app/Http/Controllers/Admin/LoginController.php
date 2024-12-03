<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ++++++++++++++ Show Login ++++++++++++++
    public function show_login_view()
    {
        return view('admin.auth.login');
    }
    // ++++++++++++++ Check Login ++++++++++++++
    public function login(LoginRequest $request)
    {
        if( auth()->guard('admin')->attempt([ 'email'=>$request->input('email'),'password'=>$request->input('password')] ) )
        {
            return redirect()->route('admin.dashboard');
        }
        else
        {
            return redirect()->route('admin.showLogin')->with(['error' => 'عفوا بيانات تسجيل الدخول غير صحيحة !!']);;
        }
    }
    // ++++++++++++++ Logout ++++++++++++++
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.showLogin');
    }

}
