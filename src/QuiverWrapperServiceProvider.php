<?php

namespace SegPartners\QuiverWrapper;

use Illuminate\Support\ServiceProvider;

class QuiverWrapperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->testConfigKeys();

        $this->publishes([
            __DIR__ . '/../config/quiver-wrapper.php' => config_path('quiver-wrapper.php'),
        ], 'quiver-wrapper-configs');
    }

    private function testConfigKey(string $key)
    {
        $completeKey = 'quiver-wrapper.' . $key;
        $exception = new \UnexpectedValueException("The '{$completeKey}' key has not been set");
        throw_if(is_null(config($completeKey)), $exception);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/quiver-wrapper.php', 'quiver-wrapper'
        );
    }

    private function testConfigKeys(): void
    {
        $this->testConfigKey('url');
        $this->testConfigKey('username');
        $this->testConfigKey('password');
        $this->testConfigKey('client_id');
        $this->testConfigKey('client_secret');
    }

}