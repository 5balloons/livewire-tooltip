<?php

namespace _5balloons\LivewireTooltip\Tests\Helpers;

class TooltipTestClass{

    public static function getSomeString(){
        return "A string";
    }

    public static function getStringWithParameter($param1){
        return "A string ".$param1;
    }

    public static function getStringWithMultipleParameter($param1, $param2){
        return "A string ".$param1.$param2;
    }

    public static function getViewContent(){
        return view('test-view-file');
    }

    public static function getViewContentWithParam($param1){
        return view('test-view-file-param', compact('param1'));
    }

}