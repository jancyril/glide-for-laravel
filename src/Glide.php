<?php

namespace Jancyril\Glide;

use League\Glide\Server;
use Illuminate\Contracts\Filesystem\Factory;

class Glide
{
    /**
     * Contains the instance of \League\Glide\Server.
     *
     * @var object
     */
    private $glide;

    /**
     * The path to image that will be manipulated.
     *
     * @var string
     */
    private $image;

    /**
     * Contains the manipulated image.
     *
     * @var string
     */
    private $modified;

    /**
     * Contains the instance of \Illuminate\Contracts\Filesystem\Factory
     *
     * @var object
     */
    private $filesystem;

    public function __construct(Server $glide, Factory $filesystem)
    {
        $this->glide = $glide;
        $this->filesystem = $filesystem;
    }

    /**
     * Set the image to be manipulated.
     *
     * @param string $image
     *
     * @return \Jancyril\Glide\Glide
     */
    public function image($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Manipulate an image by providing an array of modifications.
     *
     * @param array $params
     *
     * @return \Jancyril\Glide\Glide
     */
    public function manipulate(array $params)
    {
        $this->modified = $this->makeImage($params);

        return $this;
    }

    /**
     * Resize an image by providing width and optional height.
     *
     * @param int $width
     * @param int $height
     *
     * @return \Jancyril\Glide\Glide
     */
    public function resize(int $width, int $height)
    {
        $this->modified = $this->makeImage([
            'w' => $width,
            'h' => $height,
        ]);

        return $this;
    }

    public function addWatermark(string $markImage, array $attributes = [])
    {
        $attributes['mark'] = $markImage;

        $this->modified = $this->makeImage($attributes);

        return $this;
    }

    /**
     * This will save the file to the desired path.
     *
     * @param string $output
     *
     * @return string
     */
    public function save($output)
    {
        if ($this->filesystem->getDefaultDriver() != 'local') {
            $file = file_get_contents(config('glide.glide_asset_url').$this->modified);
        } else {
            $file = file_get_contents($this->modified);
        }

        $this->filesystem->put($output, $file);

        return $output;
    }

    /**
     * This will make the image.
     *
     * @param array $attributes
     *
     * @return string
     */
    private function makeImage(array $attributes)
    {
        return $this->glide->makeImage($this->image, $attributes);
    }
}
