<?php

use Illuminate\Http\Request;

if (! function_exists('request')) {
    /**
     * Get an instance of the current request or an input item from the request.
     *
     * @param null $key
     * @param mixed $default
     *
     * @return Request|string|array
     */
    function request($key = null, $default = null)
    {
        if (is_null($key)) {
            return app('request');
        }

        if (is_array($key)) {
            return app('request')->only($key);
        }

        $value = app('request')->get($key);

        return is_null($value) ? value($default) : $value;
    }
}

if (! function_exists('getPHPtimezone')) {
    /**
     * @param $latitude
     * @param $longitude
     * @return mixed
     */
    function getPHPtimezone($latitude, $longitude) {
        $diffs = array();
        foreach(DateTimeZone::listIdentifiers() as $timezoneID) {
            $timezone = new DateTimeZone($timezoneID);
            $location = $timezone->getLocation();
            $tLat = $location['latitude'];
            $tLng = $location['longitude'];
            $diffLat = abs($latitude - $tLat);
            $diffLng = abs($longitude - $tLng);
            $diff = $diffLat + $diffLng;
            $diffs[$timezoneID] = $diff;
        }

        $timezone = array_keys($diffs, min($diffs));
        return $timezone[0];
    }
}


