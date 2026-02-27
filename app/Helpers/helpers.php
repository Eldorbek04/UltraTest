<?php

use App\Models\Setting;

if (!function_exists('get_setting')) {
    function get_setting($key, $default = 0) {
        $setting = Setting::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}