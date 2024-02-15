<?php

namespace _5balloons\LivewireTooltip;

use Livewire\Livewire;
use Illuminate\Support\ServiceProvider;

class LivewireTooltipServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Livewire::component('livewire-tooltip', Tooltip::class);
    }
}