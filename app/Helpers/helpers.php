<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Upload Base64 Image
 */

if(!function_exists('base64_to_image')){

    function base64_to_image($base64String,$prefix)
    {
        $photo = base64_decode($base64String);

        $photo_name= $prefix.time().Str::random(6). '.jpg';

        Storage::disk('public')->put($photo_name,$photo);

        return $photo_name;

    }
}

/**
 * Get Storage File
 */

if(! function_exists('get_storage_file_path')) {

    function get_storage_file_path($file = null)
    {
        return Storage::url($file);
    }
}

/**
* Check Request Auth User Id
*
*/

if(!function_exists('check_auth_user_id')) {

    function check_auth_user_id($authUserId,$passedId) {

        return $authUserId == $passedId;
    }
}
