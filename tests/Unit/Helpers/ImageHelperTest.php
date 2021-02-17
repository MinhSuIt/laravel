<?php

namespace Tests\Unit\Helpers;

use App\Helper\ImageHelper;
use App\Models\Category\Category;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageHelperTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->imageHelper = resolve(ImageHelper::class);
        // $this->imageHelper = app()->make(ImageHelper::class);
    }
    public function uploadProvider()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        return [
            [
                'dir' => 'abc',
                'fromUrl' => $file->getRealPath(),
                'width' => 100,
                'height' => 100,
                'watermark' => false,
                'imageType' => 'jpg',
                'disk' => 'public'
            ],
            [
                'dir' => 'abc',
                'fromUrl' => $file->getRealPath(),
                'width' => 100,
                'height' => 100,
                'watermark' => false,
                'imageType' => 'jpg',
                'disk' => 'anc'
            ],
        ];
    }
    /**
     * test
     * @dataProvider uploadProvider
     */
    public function test_upload($dir, $fromUrl, $width, $height, $watermark, $imageType, $disk)
    {

        $link = $this->imageHelper->upload($dir, $fromUrl, $width, $height, $watermark, $imageType, $disk);

        if ($link) {
            Storage::fake($dir);
            Storage::disk($dir)->assertExists($link);
        } else {
            $this->assertEquals('', $link);
        }
        return $link;
    }
    /** 
     * @test 
     * 
     */
    public function test_get_image()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');
        $begin = config('app.url');
        $disk = 'public';
        $link = $this->imageHelper->upload(Category::IMAGE_DIR, $file->getRealPath(), Category::IMAGE_WIDTH, Category::IMAGE_HEIGHT, false, 'jpg', $disk);
        if ($link) {
            $this->assertStringStartsWith($begin, $this->imageHelper->getImage($link));
        } else {
            $this->assertEquals('', $link);
        }
        return [
            'link' => $link,
            'disk' => $disk,
        ];
    }


    /** @test
     * @depends test_get_image
     */
    public function test_delete($data)
    {
        Storage::fake('abc');
        $this->imageHelper->delete($data['link']);
        Storage::disk($data['disk'])->assertMissing($data['link']);
    }
    /** 
     * @test 
     * */
    public function test_get_encode()
    {
        $file = UploadedFile::fake()->image('avatar.jpg');

        $link = $this->imageHelper->upload('abc', $file->getRealPath(), 100, 100);
        $stringbase64 = $this->imageHelper->getEncode(asset(Storage::url($link)));//asset(Storage::url($link)) thay bằng storage_path thử
        $this->assertStringStartsWith('data:image/jpeg;base64',$stringbase64);
    }
}
