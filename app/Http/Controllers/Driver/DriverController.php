<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Drivers;
use App\Models\Payments;
use App\Models\Ride;
use App\Models\RideRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class DriverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:driver');
    }

    public function updateLocation(Request $request)
    {
        try {
            $driver = Drivers::findOrFail(Auth::id());
            $driver->update([
                "latitude" => $request->latitude,
                "longitude" => $request->longitude,
            ]);
            return response()->json([
                $request->all(),
                "driver" => $driver,
            ]);
        } catch (Exception $e) {
            Log::error('Error in updating driver location ' . $e);
        }
    }

    public function checkin()
    {
        try {
            $driver = Drivers::findOrFail(Auth::id());
            $driver->status = "available";
            $driver->save();
            return back()->withMessage("Checkin success");
        } catch (Exception $e) {
            Log::error("Error in checkin driver");
        }
    }

    public function checkout()
    {
        try {
            $driver = Drivers::findOrFail(Auth::id());
            $driver->status = "away";
            $driver->save();
            return back()->withMessage("Checkout success");
        } catch (Exception $e) {
            Log::error("Error in checkout driver");
            return back();
        }
    }


    public function update(Drivers $driver, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:drivers,email,' . $driver->id,
            'phone' => 'required|digits:10|unique:drivers,phone,' . $driver->id,
            'location' => 'required',
        ]);
        $driver->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'location' => $request->location,
        ]);

        return back()->withMessage("Details updated");
    }

    public function show()
    {
        try {
            $driver = Drivers::findOrFail(Auth::id());
            return view('driver.home', compact('driver'));
        } catch (Exception $e) {
            Log::error("Error in getting the driver data");
            return back();
        }
    }
}
