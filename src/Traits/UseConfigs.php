<?php

namespace SegPartners\QuiverWrapper\Traits;

use Illuminate\Contracts\Foundation\Application;

trait UseConfigs
{

    protected function getConfig(string $config)
    {

        $config_key = 'quiver-wrapper.' . $config;

        $value = config($config_key);

        if (!$value) {

            throw new \Exception("The '{$config_key}' was not setup");
        }

        return $value;
    }

}
