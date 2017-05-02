<?php

namespace Jancyril\Glide\Test;

use League\Glide\Server;
use League\Glide\ServerFactory;
use League\Flysystem\Filesystem;
use Illuminate\Container\Container;
use League\Flysystem\Adapter\Local;

class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $server;

    protected function setUp()
    {
        parent::setUp();

        $app = new Container();

        $app->singleton(
            Server::class,
            function ($app) {
                return ServerFactory::create([
                    'source' => new Filesystem(new Local(dirname(__DIR__))),
                    'cache' => new Filesystem(new Local(dirname(__DIR__))),
                    'watermarks' => new Filesystem(new Local(dirname(__DIR__))),
                    'source_path_prefix' => 'images',
                    'cache_path_prefix' => '.cache',
                    'watermarks_path_prefix' => 'images/watermark',
                ]);
            }
        );

        $this->server = $app->make(Server::class);

        mkdir($this->temporaryFolder());
    }

    protected function tearDown()
    {
        parent::tearDown();

        array_map('unlink', glob($this->temporaryFolder().'/*.*'));

        rmdir($this->temporaryFolder());
    }

    protected function temporaryFolder()
    {
        return dirname(__DIR__).DIRECTORY_SEPARATOR.'modified';
    }
}
