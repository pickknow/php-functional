<?php

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
    $funcs = array_reverse(func_get_args());
    return function($input) use ($funcs) {
        return array_reduce($funcs,function($pre,$next) {
            return $next($pre);
        },$input);
    };
}


