<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Drivers;
use App\Models\Ride;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function home()
    {
        $previousDayRideCount = Ride::whereDate('created_at', "=", now()->subDay())->count();
        return view('admin.home', compact('previousDayRideCount'));
    }

    public function previousDayRide()
    {
        $rides = Ride::whereDate('created_at', "=", now()->subDay())
            ->where('status', 'completed')
            ->paginate(10);
        return view('admin.ride.previousDayRides', compact('rides'));
    }

    public function destroyRide(Ride $ride)
    {
        $ride->delete();
        return back()->withMessage("Ride deleted successfully!");
    }

    public function showRide($id)
    {
        $ride = Ride::with(['driver', 'payment', 'rating'])
            ->find($id);
        return view('admin.ride.show', compact('ride'));
    }

    public function driverIndex()
    {
        $drivers = Drivers::with('ratings')->paginate(5);
//        dd($drivers[1]->ratings);
        return view('admin.driver.index', compact('drivers'));
    }
}
