<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingRequest;
use App\Models\Rating;
use App\Models\Ride;
use App\Traits\UserCheckAccessTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PHPUnit\Exception;

class RatingController extends Controller
{
    use UserCheckAccessTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function update($id, RatingRequest $request)
    {
        try {
            $rating = Rating::where('ride_id', $id)->first();
            $ride = Ride::findOrFail($rating->ride_id);
            $this->checkForAccess($ride->user_id);
            $rating->rating = $request->rating;
            $rating->save();
            return back()->withMessage("Thanks for your time");
        } catch (Exception $e) {
            Log::error('Error in rating ' . $e);
        }
    }
}
