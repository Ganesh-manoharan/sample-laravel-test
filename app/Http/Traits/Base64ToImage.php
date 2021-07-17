<?php

namespace App\Http\Traits;

//class to get the encrypted and decrypted values based on AWS KMS
trait Base64ToImage
{
    public static function base64todata($request){
        $image_parts = explode(";base64,", $request);
        $image_data = array();
        $image_extension = explode("/", $image_parts[0]);
        $image_data['extension'] = $image_extension[1];
        $image_data['data'] = base64_decode($image_parts[1]);
        return $image_data;
    }
}