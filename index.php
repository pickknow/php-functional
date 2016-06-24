<?php
include __DIR__.'/Fp.php';

$add = function($a,$b){
    return $a + $b;
};

$add1 = curry($add,1);


$add2 = curry($add,2);

$add3 = compose($add1,$add2);

var_dump($add3(3));

$add4 = compose($add1,$add3);

var_dump($add4(4));