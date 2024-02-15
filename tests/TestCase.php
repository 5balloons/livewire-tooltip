<?php

namespace _5balloons\LivewireTooltip\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Livewire\LivewireServiceProvider;
use _5balloons\LivewireTooltip\LivewireTooltipServiceProvider;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            LivewireTooltipServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:Hupx3yAySikrM2/edkZQNQHslgDWYfiBfCuSThJ5SK8=');
    }
}