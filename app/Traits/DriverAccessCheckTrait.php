<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait DriverAccessCheckTrait
{
    public function checkForAccess($driver_id)
    {
        if ($driver_id != Auth::guard('driver')->id()) {
            Log::error("Unauthorized access " . Auth::guard('driver')->user());
            return abort('403', 'Unauthorized Access');
        }
    }
}
