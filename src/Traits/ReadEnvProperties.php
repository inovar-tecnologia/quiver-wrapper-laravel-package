<?php

namespace SegPartners\QuiverWrapper\Traits;

trait ReadEnvProperties
{

    protected function getEnvProperty($envVariable)
    {
        $value = env($envVariable);

        if (!$value) {
            throw new \Exception("The '{$envVariable}' is not setup in .env file");
        }

        return $value;
    }
}
