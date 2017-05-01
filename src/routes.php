<?php

Route::get(config('glide.base_url').'/{path}', function (League\Glide\Server $server, $path) {
    $content = $server->outputImage($path, request()->all());

    return response($content);
})->name('glide');
