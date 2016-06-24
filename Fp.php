<?php
function dump(){
    $args = func_get_args();
    array_map(function($item) {
        echo '<br>';
        var_dump($item);       
    },$args);
}
function curry($callback) {
    $args = array_slice(func_get_args(),1);
    $refl = new \ReflectionFunction($callback);
    $length = $refl->getNumberOfRequiredParameters();        
    return curryHandler($callback,$args,$length);
}
function curryHandler($callback,$args,$length) {
    if($length <=0) return call_user_func_array($callback,$args);
    return function() use ($callback,$args,$length) {
        $newArgs = array_merge($args,func_get_args());        
        return curryHandler($callback,$newArgs,$length-count($newArgs));
    };            
}

function compose(){
    $args = array_reverse(func_get_args());
    return function($input) use ($args) {
        return array_reduce($args,function($pre,$next) {
            return $next($pre);
        },$input);
    };
}
//reduce($functin,$init,$data)
function reduce(){
    $func =  curry(function($fn,$init,$data){
        return array_reduce($data,$fn,$init);
    });
    return call_user_func_array($func,func_get_args());
}

function map($callback){
    return function($input) use ($callback) {
        return array_map($callback,$input);
    };
}

function filter($callback) {
    return function($input) use ($callback) {
        return array_filter($input,$callback);
    };
}

function chain($data){
    return new Chain($data);
}

class Chain{
    private $value;
    function __construct($value){
        $this->value = $value;
    }

    function map($callback) {
        $this->value = array_map($callback,$this->value);
        return $this;
    }
    function reduce($callback,$int) {
        $this->value = array_reduce($this->value,$callback,$init);
        return $this;
    }
    function value(){
        return $this->value;
    }
}