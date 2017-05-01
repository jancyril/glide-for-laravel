<?php

namespace Janitor\Glide\Test;

use League\Glide\Server;
use Janitor\Glide\Glide;
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

        $this->glide->image($this->image)->manipulate($params)->save($this->filepath());

        $this->assertFileExists($this->filepath());
    }

    /** @test **/
    public function it_can_resize_an_image()
    {
        $this->glide->image($this->image)->resize(40, 60)->save($this->filepath());

        $this->assertFileExists($this->filepath());
    }

    /** @test **/
    public function it_can_add_a_watermark()
    {
        $this->glide->image($this->image)->addWatermark('watermark.png')->save($this->filepath());

        $image = dirname(__DIR__).DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$this->image;

        $this->assertFileNotEquals($image, $this->filepath());
        $this->assertFileExists($this->filepath());
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
