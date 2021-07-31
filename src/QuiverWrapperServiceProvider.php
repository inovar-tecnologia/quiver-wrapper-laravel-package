<?php

namespace SegPartners\QuiverWrapper;

use Illuminate\Support\ServiceProvider;

class QuiverWrapperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/quiver-wrapper.php' => config_path('quiver-wrapper.php'),
        ], 'quiver-wrapper-configs');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/quiver-wrapper.php', 'quiver-wrapper'
        );
    }

}