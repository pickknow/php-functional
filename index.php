<?php
include __DIR__.'/Fp.php';

$add = function($a,$b){
    return $a + $b;
};

$add1 = curry($add,1);


$add2 = curry($add,2);

$add3 = compose($add1,$add2);

// var_dump($add3(3));

$add4 = compose($add1,$add3);

// var_dump($add4(4));

//reduce
$fn = function($pre,$next) {
    return $pre + $next;
};

$data = [1,2,3,4,5];

$reduce = reduce($fn,0);
dump($reduce($data));

$reduce = compose($add1,$add2,reduce($fn,10));
dump($reduce($data));

$chain = chain($data)->map(function($item){
   return ++$item;
})->reduce($fn,0)->value();
dump($chain);
var_dump('dddd',$data);
dump('dddd',$data);