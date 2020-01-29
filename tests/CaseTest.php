<?php

namespace Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase;

class CaseTest extends TestCase
{

    public function testCaseTest()
    {
        $this->assertTrue(true);
    }

    /** @param Application $app */
    protected function getEnvironmentSetUp($app)
    {
        $app->config['quiver-wrapper'] = require __DIR__. '/../config/quiver-wrapper.php';
    }
}