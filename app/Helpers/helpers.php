<?php
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\File;

/**
 * Upload File To Akoneya Media
 */

if(!function_exists('base64ImageUploadToAkoneyaMedia')){

    function base64ImageUploadToAkoneyaMedia($base64String,$directoryName)
    {
        $file = base64_decode($base64String);
        $fileExtension = ".png";
        $fileName = time().Str::random(6).$fileExtension;
        $mediaPath = $directoryName."/".$fileName;

        if(Storage::put($mediaPath,$file))
        {
            return $mediaPath;
        }

        return null;
    }
}

/**
 * Delete File From Akoneya Media
 */
if(!function_exists('deleteFileFromAkoneyaMedia')) {

    function deleteFileFromAkoneyaMedia($filePath)
    {
        Storage::delete($filePath);
    }
}

/*
 * Get Fiel URL from Akoneya Medai
 */
if(!function_exists('getFileUrlFromAkoneyaMedia')){

    function getFileUrlFromAkoneyaMedia($filePath)
    {
        return Storage::url($filePath);
    }
}

if(!function_exists("str_to_24hr_format")){
	
	function str_to_24hr_format($value)
	{
		return date("Y-m-d H:i:s", strtotime($value));
	}
}

if (!function_exists("decryptToken")) {
    function decryptToken($token)
    {
        if (!defined('AES_256_CBC')) {
            define('AES_256_CBC', 'aes-256-cbc');
        }

        $encryption_key = Config::get('services.encryptionKey');

        $iv = Config::get('services.ivKey');

        return openssl_decrypt($token, AES_256_CBC, $encryption_key, 0, $iv);
    }
}
