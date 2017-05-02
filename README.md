# Glide for Laravel
[![Build Status](https://travis-ci.org/jancyril/glide-for-laravel.svg?branch=master)](https://travis-ci.org/jancyril/glide-for-laravel)

A package to easily use Glide in Laravel 5.

## Installation
Download via composer:

`composer require jancyril/glide-for-laravel`

Add the GlideServiceProvider to your config/app.php inside the providers array:

```php
'providers' => [
    Janitor\Glide\GlideServiceProvider::class,
];
```

Publish the config file for this package:

`php artisan vendor:publish --provider="Janitor\Glide\GlideServiceProvider"`

Modify the values of your config/glide.php file to suit your needs.

## Usage

Inject `Janitor\Glide\Glide` in the class that will use it.

Resizing an image:

```php
$this->glide->image($imagePath)
            ->resize(200,200)
            ->save($outputFile);
```

Adding a watermark to the image:

```php
$this->glide->image($imagePath)
            ->addWatermark($watermarkImage)
            ->save($outputFile);
```

Manipulate image using available parameters from glide:

```php
$parameters = [
    'w' => 200,
    'h' => 200,
    'fit' => fill,
];

$this->glide->image($imagePath)
            ->manipulate($parameters)
            ->save($outputFile);
```

To see all available parameters visit [Glide Page](http://glide.thephpleague.com/1.0/api/quick-reference/).
