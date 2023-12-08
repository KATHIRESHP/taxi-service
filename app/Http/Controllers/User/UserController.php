<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Ride;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userRides()
    {
        $rides = Ride::where('user_id', Auth::id())
            ->orderBy('id', 'DESC')
            ->paginate(5);
        return view('user.ride.rides', compact('rides'));
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        try {
            $user = User::findOrFail(Auth::id());
            return view('user.home', compact('user'));
        } catch (Exception $e) {
            Log::error("Error in getting the user data");
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->withMessage("Details updated");
    }

}
