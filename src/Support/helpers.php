<?php
/**
 * Created by Muhaimenul.
 * User: Muhaimenul
 * Date: 6/17/2021
 * Time: 9:51 PM
 */

if(! function_exists('_auth')) {
    function _auth() {
        return auth();
    }
}

if(! function_exists('_auth_user')) {
    function _auth_user() {
        return _auth()->user();
    }
}

if(! function_exists('is_authenticated')) {
    function is_authenticated() {
        return _auth()->check();
    }
}

if(! function_exists('getUniqueCode')) {
    function getUniqueCode()
    {
        return md5(microtime() . uniqid(rand(), true)) . time();
    }
}

if(!function_exists('isUrl')) {
    function isUrl($url) {
        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            return false;
        }
        return true;
    }
}

if(!function_exists('string_plural')) {
    function string_plural($string) {
        \Illuminate\Support\Str::plural($string);
    }
}

if(!function_exists('string_snake')) {
    function string_snake($string) {
        \Illuminate\Support\Str::snake($string);
    }
}
