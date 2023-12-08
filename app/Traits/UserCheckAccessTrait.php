<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait UserCheckAccessTrait
{
    public function checkForAccess($user_id)
    {
        if ($user_id != Auth::id()) {
            Log::error("Unauthorized access " . Auth::user());
            return abort('403', 'Unauthorized Access');
        }
    }
}
