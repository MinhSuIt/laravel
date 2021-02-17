<?php

namespace App\Library\Traits;

use App\Helper\ImageHelper;
use DOMDocument;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * HTML string has image
 */

trait ContentHasImage
{
    public $imageHelper;
    public $ContentImage = [];


    // sử dụng public static function boot + tên trait để tự động load trước khi sử dụng class ,xem Translatable viết theo
    // https://laravel-news.com/booting-eloquent-model-traits
    // public static function bootContentHasImage()
    // {
    //     static::retrieved(function (Model $model) {

    //     });
    // }


    public function initializeContentHasImage()
    {
        $this->imageHelper = app()->make(ImageHelper::class);
    }



    
    public function setImageHelper()
    {
        $this->imageHelper = app()->make(ImageHelper::class);
    }
    function getTagsFromHTML($htmlDom, $tag)
    {
        //Extract all img elements / tags from the HTML.
        $tags = $htmlDom->getElementsByTagName($tag);
        return $tags;
    }
    public function getValueOfProperty($getTagsFromHTML, string $property)
    {
        foreach ($getTagsFromHTML as $imageTag) {
            $extractedImages[] = $imageTag->getAttribute($property);
        }
        return $extractedImages;
    }
    public function makeDomFromHTMLString($html_string)
    {
        $htmlDom = new DOMDocument();
        $htmlDom->loadHTML($html_string);
        return $htmlDom;
    }
    public function setAttributeValueFromHTMLAndUpload(string $dir, int $width, int $height, string $html_string, string $tag, string $property)
    {
        $dom = $this->makeDomFromHTMLString($html_string);
        $tags = $this->getTagsFromHTML($dom, $tag);
        $valueOfProperty = $this->getValueOfProperty($tags, $property);
        for ($i = 0; $i < count($valueOfProperty); $i++) {
            if (Str::startsWith($valueOfProperty[$i], 'data:image/')) {
                $link = $this->imageHelper->upload($dir, $valueOfProperty[$i], $width, $height);
                if (!in_array($link, array_values($this->ContentImage))) {
                    $this->ContentImage[$valueOfProperty[$i]] =  $link;

                    $tags[$i]->setAttribute($property, $this->imageHelper->getImage($link));
                    $tags[$i]->setAttribute('width', $width);
                    $tags[$i]->setAttribute('height', $height);
                } else {
                    $tags[$i]->setAttribute($property, $this->ContentImage[$valueOfProperty[$i]]);
                }
            }
        }
        return [
            'dom' => $dom->saveHTML(),
            'ContentImage' => $this->ContentImage
        ];
    }
    public function getContentForEdit(string $html_string, string $tag, string $property)
    {
        $dom = $this->makeDomFromHTMLString($html_string);
        $tags = $this->getTagsFromHTML($dom, $tag);
        $valueOfProperty = $this->getValueOfProperty($tags, $property);

        for ($i = 0; $i < count($valueOfProperty); $i++) {
            $link = $this->imageHelper->getEncode($valueOfProperty[$i]);
            $tags[$i]->setAttribute($property, $link);
        }
        return $dom->saveHTML();
    }
}
