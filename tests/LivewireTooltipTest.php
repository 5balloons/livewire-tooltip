<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\View;
use _5balloons\LivewireTooltip\Tooltip;

it('renders tooltip component correctly', function () {
    Livewire::test(ToolTip::class)
        ->assertStatus(200); 
});

it('fetches string content and updates the tooltip', function () {
    $expectedContent = 'A string';
    $methodName = '_5balloons\LivewireTooltip\Tests\Helpers\TooltipTestClass::getSomeString';
    
    Livewire::test(Tooltip::class)
        ->call('fetchContent', $methodName, [])
        ->assertSet('toolTipHtml', $expectedContent)
        ->assertSeeHtml($expectedContent);
});

it('handles passing parameter to the method', function () {


    $expectedContent = 'A string '.'123';
    $methodName = '_5balloons\LivewireTooltip\Tests\Helpers\TooltipTestClass::getStringWithParameter';
    
    Livewire::test(Tooltip::class)
        ->call('fetchContent', $methodName, ['123'])
        ->assertSet('toolTipHtml', $expectedContent)
        ->assertSeeHtml($expectedContent);
});

it('handles passing multiple parameter to the method', function () {


    $expectedContent = 'A string '.'123'.'456';
    $methodName = '_5balloons\LivewireTooltip\Tests\Helpers\TooltipTestClass::getStringWithMultipleParameter';
    
    Livewire::test(Tooltip::class)
        ->call('fetchContent', $methodName, ['123', '456'])
        ->assertSet('toolTipHtml', $expectedContent)
        ->assertSeeHtml($expectedContent);
});

it('renders content from a view file correctly', function () {

    View::addLocation(__DIR__.'/helpers'); //Adds current directory to look for view files. 

    $expectedContent = 'Test Content';
    $methodName = '_5balloons\LivewireTooltip\Tests\Helpers\TooltipTestClass::getViewContent';
    
    Livewire::test(Tooltip::class)
        ->call('fetchContent', $methodName, [])
        ->assertSee($expectedContent);
});

it('renders content from a view file with variable correctly', function () {

    View::addLocation(__DIR__.'/helpers'); //Adds current directory to look for view files. 

    $expectedContent = 'Test Content 123';
    $methodName = '_5balloons\LivewireTooltip\Tests\Helpers\TooltipTestClass::getViewContentWithParam';
    
    Livewire::test(Tooltip::class)
        ->call('fetchContent', $methodName, ['123'])
        ->assertSee($expectedContent);
});