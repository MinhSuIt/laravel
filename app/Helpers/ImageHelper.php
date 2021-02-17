<?php

namespace App\Helper;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\ImageManagerStatic as Image;

class ImageHelper
{
    function upload($dir, $fromUrl, $width, $height, $watermark = false, $imageType = "jpg", $disk = "public")
    {

        if ($fromUrl != null) {

            $fileName = "$dir/" . (string)Str::uuid() . ".$imageType";
            try {

                $image = Image::make($fromUrl)->fit(
                    $width,
                    $height
                    // ,function($constraint){
                    //     //nếu kích thước nhỏ hơn width,height thì sẽ zoom to lên nhưng bị vỡ 
                    //     $constraint->upsize();
                    // }
                )->stream();
                // if ($watermark) {
                //     $image->insert('public/watermark.png');
                // }
                if (!file_exists($disk)) {
                    mkdir($disk, 666, true);
                }
                //mock storage chỗ này
                Storage::disk($disk)->put($fileName, $image);

                return $fileName;
            } catch (NotReadableException $e) {
                return '';
            }
        }
        return '';
    }
    public function getImage($linkImage)
    {
        if (!$linkImage)
            return;
        return asset(Storage::url($linkImage));
    }

    function delete($link, $disk = "public")
    {
        Storage::disk($disk)->delete($link);
    }
    function getEncode($link)
    {
        $encode = Image::make($link)->encode('data-url')->encoded;
        return $encode;
    }
    
}
