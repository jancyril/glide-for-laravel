<?php

return [
    // This is the folder where you save your images, relative to your source
    // Example: images; defaults to uploads
    'source_path_prefix' => env('GLIDE_IMAGE_PATH', 'uploads'),

    // This is the folder where to save the cached images.
    // Example: cache_folder; defaults to glide_cache
    'cache_path_prefix' => env('GLIDE_CACHE_PATH', 'glide_cache'),

    // This is the segment in the URL for the route.
    // Defaults to image.
    'base_url' => env('GLIDE_BASE_URL', 'image'),

    // This is the destination path for manipulated images.
    // Defaults to modified.
    'destination_path' => env('GLIDE_IMAGE_DESTINATION', 'modified'),

    // This is the URL of your assets.
    // Example: http://example.com/; no default value must be filled.
    'glide_asset_url' => env('GLIDE_ASSET_URL'),
];
