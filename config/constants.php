<?php

if (!function_exists('storageUrl')) {
    function storageUrl($path)
    {
        return asset('storage/' . preg_replace('/^public\//', '', $path));
    }
}
