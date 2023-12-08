<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function check(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only(['email', 'password']);
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.home');
        } else {
            return back()->withError("Check credentials again");
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return to_route('admin.login');
    }
}
