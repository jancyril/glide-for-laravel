<?php

namespace JanCyril\Glide;

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
    private $modifiedImage;

    /**
     * Contains the instance of \Illuminate\Contracts\Filesystem\Factory.
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
     * @return \JanCyril\Glide\Glide
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Manipulate an image by providing an array of modifications.
     *
     * @param array $options
     *
     * @return \JanCyril\Glide\Glide
     */
    public function manipulate(array $options)
    {
        $this->modifiedImage = $this->makeImage($options);

        return $this;
    }

    /**
     * This will add a filter effect to the image.
     *
     * @param string $effect
     *
     * @return \JanCyril\Glide\Glide
     */
    public function addFilter(string $effect)
    {
        $this->modifiedImage = $this->makeImage(['filt' => $effect]);

        return $this;
    }

    /**
     * This will add a watermark to the modified image.
     *
     * @param string $watermarkImage
     * @param array  $options
     *
     * @return \JanCyril\Glide\Glide
     */
    public function addWatermark(string $watermarkImage, array $options = [])
    {
        $options['mark'] = $watermarkImage;

        $this->modifiedImage = $this->makeImage($options);

        return $this;
    }

    /**
     * This will add blur effect to the image.
     *
     * @param int $value
     *
     * @return \JanCyril\Glide\Glide
     */
    public function blur(int $value)
    {
        $this->modifiedImage = $this->makeImage(['blur' => $value]);

        return $this;
    }

    /**
     * This will crop the image.
     *
     * @param string $position
     *
     * @return \JanCyril\Glide\Glide
     */
    public function crop(string $position)
    {
        $this->modifiedImage = $this->makeImage(['fit' => $position]);

        return $this;
    }

    /**
     * This will add a pixelated effect toe the image.
     *
     * @param int $value
     *
     * @return \JanCyril\Glide\Glide
     */
    public function pixelate(int $value)
    {
        $this->modifiedImage = $this->makeImage(['pixel' => $value]);

        return $this;
    }

    /**
     * Resize an image by providing width and optional height.
     *
     * @param int $width
     * @param int $height
     *
     * @return \JanCyril\Glide\Glide
     */
    public function resize(int $width, int $height)
    {
        $this->modifiedImage = $this->makeImage([
            'w' => $width,
            'h' => $height,
        ]);

        return $this;
    }

    public function rotate($orientation)
    {
        $this->modifiedImage = $this->makeImage(['or' => $orientation]);

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
            $file = file_get_contents(config('glide.glide_asset_url').$this->modifiedImage);
        } else {
            $file = file_get_contents($this->modifiedImage);
        }

        $this->filesystem->put($output, $file);

        return $output;
    }

    /**
     * This will make the image.
     *
     * @param array $options
     *
     * @return string
     */
    private function makeImage(array $options)
    {
        return $this->glide->makeImage($this->image, $options);
    }
}
