<?php

namespace App\Helpers;

use App\Setting;
use Carbon\Carbon;

class SettingsHelper {

    /**
     * Get a Setting object by name
     *
     * @param   String                  $name   The name field in the setting table
     * @return  \App\Setting|boolean    $name   The Setting object. Returns false if no mathcing obj.
     */
    public static function get(String $name)
    {
        $name = Setting::where('name', $name)->get();

        if(sizeof($name) == 0) {
            return false;
        } else if(sizeof($name) == 1) {
            return $name[0];
        } else {
            $name = $name->keyBy('name');
            return $name->all();
        }
    }

    /**
     * Create / update value for Setting object.
     *
     * @param   String  $name   Name of setting
     * @param   String  $value  Value of setting
     * @return  \App\Setting
     */
    public static function set(String $name, String $value)
    {
        $setting = SettingsHelper::get($name);

        if($setting !== false) {
            if($value == false) {
                $value = "0";
            }
            $setting->value = $value;
            $setting->save();
        } else {
            $setting = Setting::create([
                'name' => $name,
                'value' => $value,
            ]);
        }

        return $setting;
    }

    /**
     * Get the app's base path
     *
     * @return string
     */
    public static function getBase()
    {
        $base = env('BASE_PATH', '/');
        if($base == '') {
            $base = '/';
        } else {
            if($base[0] != '/') {
                $base = '/' . $base;
            }
            if($base[-1] != '/') {
                $base = $base . '/';
            }
        }
        return $base;
    }
}