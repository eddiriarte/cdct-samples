<?php

namespace Tests\Order\Components;

abstract class TestCase extends \Laravel\Lumen\Testing\TestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require dirname(__DIR__, 2) . '/bootstrap/app.php';
    }
}
