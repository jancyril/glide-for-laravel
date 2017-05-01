<?php

namespace Janitor\Glide\Test;

use League\Flysystem\Filesystem as File;
use Illuminate\Filesystem\FilesystemManager;

class Filesystem extends FilesystemManager
{
    public function __construct($app)
    {
        parent::__construct($app);
    }

    public function getDefaultDriver()
    {
        return 'local';
    }

    public function getConfig($name)
    {
        return [
            'driver' => 'local',
            'root' => '/',
        ];
    }
}
