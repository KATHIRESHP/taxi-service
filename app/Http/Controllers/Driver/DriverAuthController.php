<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Http\Requests\DriverAuthRequest;
use App\Models\Drivers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DriverAuthController extends Controller
{
    public function register(DriverAuthRequest $request)
    {
        Drivers::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'location' => $request->location,
            'phone' => $request->phone,
            'latitude' => 10.10, // dummy coordinates
            'longitude' => 10.10, // dummy coordinates
        ]);
        return to_route('driver.login')->withMessage("Driver registered successfully");
    }

    public function check(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:drivers,email',
            'password' => 'required|min:8',
        ]);
        $cred = $request->only('email', 'password');

        if (Auth::guard('driver')->attempt($cred)) {
            return redirect()->route('driver.home')->withMessage("Login success");
        } else {
            return back()->withError("Invalid credentials");
        }
    }

    public function logout()
    {
        Auth::guard('driver')->logout();
        return to_route('driver.login');
    }
}
