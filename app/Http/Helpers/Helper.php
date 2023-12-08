<?php

class Helper
{
    public static function calculateDistance($src_lat, $src_long, $dest_lat, $dest_long, $unit)
    {
        if (($src_lat == $dest_lat) && ($src_long == $dest_long)) {
            return 0;
        }
        else {
            $theta = $src_long - $dest_long;
            $dist = sin(deg2rad($src_lat)) * sin(deg2rad($dest_lat)) +  cos(deg2rad($src_lat)) * cos(deg2rad($dest_lat)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);
            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    public static function fareCalculator($distance, $start, $end) {
        $minutes = abs($end->getTimestamp() - $start->getTimestamp()) / 60;
        $timeFare = ($minutes * 2); // per minute Rs. 2
        $distanceFare = ($distance * 12); // per KM Rs. 12
        return ($timeFare + $distanceFare);
    }
}
