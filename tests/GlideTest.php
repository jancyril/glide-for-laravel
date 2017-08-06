<?php

namespace JanCyril\Glide\Test;

use League\Glide\Server;
use JanCyril\Glide\Glide;
use Illuminate\Container\Container;

class GlideTest extends TestCase
{
    private $glide;

    private $image = 'SampleImage.png';

    protected function setUp()
    {
        parent::setUp();

        $this->createGlide();
    }

    /** @test **/
    public function it_can_manipulate_an_image()
    {
        $params = [
            'w' => 200,
            'fit' => 'crop-left',
            'blur' => 5,
        ];

        $this->glide->setImage($this->image)->manipulate($params)->save($this->filepath());

        $this->assertFileExists($this->filepath());
    }

    /** @test **/
    public function it_can_resize_an_image()
    {
        $this->glide->setImage($this->image)->resize(40, 60)->save($this->filepath());

        $this->assertFileExists($this->filepath());
    }

    /** @test **/
    public function it_can_add_a_watermark()
    {
        $this->glide->setImage($this->image)->addWatermark('watermark.png')->save($this->filepath());

        $this->assertFileNotEquals($this->originalImagePath(), $this->filepath());
        $this->assertFileExists($this->filepath());
    }

    /** @test **/
    public function it_can_crop_an_image()
    {
        $this->glide->setImage($this->image)->crop('100,100,915,155')->save($this->filepath());

        $this->assertFileNotEquals($this->originalImagePath(), $this->filepath());
        $this->assertFileExists($this->filepath());
    }

    /** @test **/
    public function it_can_pixelate_an_image()
    {
        $this->glide->setImage($this->image)->pixelate(5)->save($this->filepath());

        $this->assertFileNotEquals($this->originalImagePath(), $this->filepath());
        $this->assertFileExists($this->filepath());
    }

    /** @test **/
    public function it_can_blur_an_image()
    {
        $this->glide->setImage($this->image)->blur(5)->save($this->filepath());

        $this->assertFileNotEquals($this->originalImagePath(), $this->filepath());
        $this->assertFileExists($this->filepath());
    }

    /** @test **/
    public function it_can_add_a_filter_to_an_image()
    {
        $this->glide->setImage($this->image)->addFilter('sepia')->save($this->filepath());

        $this->assertFileNotEquals($this->originalImagePath(), $this->filepath());
        $this->assertFileExists($this->filepath());
    }

    /** @test **/
    public function it_can_rotate_an_image()
    {
        $this->glide->setImage($this->image)->rotate(90)->save($this->filepath());

        $this->assertFileNotEquals($this->originalImagePath(), $this->filepath());
        $this->assertFileExists($this->filepath());
    }

    private function originalImagePath()
    {
        return dirname(__DIR__).DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$this->image;
    }

    private function filepath()
    {
        return $this->temporaryFolder().'/Sample.png';
    }

    private function createGlide()
    {
        $app = new Container();

        $app->singleton(
            Glide::class,
            function ($app) {
                return new Glide(
                    $this->server,
                    new Filesystem($app)
                );
            }
        );

        $this->glide = $app->make(Glide::class);
    }
}
