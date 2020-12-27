<?php
namespace App\Traits;
use Illuminate\Support\Str;


//  file includes all helper function for chat controller

trait UploadMedia
{

    public function UploadMedia($media){
        $media_name = Str::random(10);
        $extention = Str::lower($media->getClientOriginalExtension());

        if ($extention =='jpg'||$extention =='png'||$extention =='jpeg'||$extention =='gif') {
            $upload_path = 'media/image/';
            return $extention;
        }elseif ($extention=='mp4') {
            $upload_path = 'media/video/';
        }
        $media_full_name = $media_name. '.' . $extention;
        $media_url = $upload_path. $media_full_name;
        $media->move($upload_path,$media_full_name);

        return $media_url;
    }
}

