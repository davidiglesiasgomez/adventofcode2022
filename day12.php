<?php

include_once('vendor/autoload.php');

$input = file_get_contents('input/input.day12.txt');

// $input = <<<EOD
// Saa
// aaa
// aaa
// EOD;

// $input = <<<EOD
// Sabcdefghijklmnopqrstuvwxyz
// abcdefghijklmnopqrstuvwxyzz
// abcdefghijklmnopqrstuvEzzzz
// EOD;

// $input = <<<EOD
// Sabqponm
// abcryxxl
// accszExk
// acctuvwj
// abdefghi
// EOD;

$day12Obj = new \AdventOfCode2022\Day12($input);
echo 'Posicion inicial: ' . json_encode($day12Obj->obtenerPosicionInicial()) . PHP_EOL;
echo 'Posicion final: ' . json_encode($day12Obj->obtenerPosicionFinal()) . PHP_EOL;
echo 'Distancia ' . $day12Obj->obtainFewerSteps([0, 20], [52, 20]) . PHP_EOL;
echo 'Distancia ' . $day12Obj->obtainFewerStepsFromElevation() . PHP_EOL;
