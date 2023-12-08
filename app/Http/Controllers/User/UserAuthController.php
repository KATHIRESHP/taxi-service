<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAuthController extends Controller
{
    public function register(UserAuthRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return to_route('user.login')->withMessage("User registered successfully");
    }

    public function check(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required|min:8',
        ]);
        $cred = $request->only('email', 'password');

        if (Auth::attempt($cred)) {
            return redirect()->route('user.home')->withMessage("Login success");
        } else {
            return back()->withError("Invalid credentials");
        }
    }

    public function logout()
    {
        Auth::logout();
        return to_route('user.login');
    }
}
