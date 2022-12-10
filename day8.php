<?php

include_once('vendor/autoload.php');

$lines = file('input.day8.txt');
// echo print_r($lines, true) . PHP_EOL;

$day8Obj = new \AdventOfCode2022\Day8($lines);
echo 'Contar visibles ' . $day8Obj->contarVisibles() . PHP_EOL;
echo 'Maximo visibles ' . $day8Obj->obtenerMaximoArbolesVisiblesDesdeCualquierArbol() . PHP_EOL;
