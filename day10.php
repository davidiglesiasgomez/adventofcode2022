<?php

include_once('vendor/autoload.php');

$lines = file('input/input.day10.txt');
// echo print_r($lines, true) . PHP_EOL;

$day10Obj = new \AdventOfCode2022\Day10($lines);
echo 'Suma ' . $day10Obj->sumSignalStrengthAtCycles([20, 60, 100, 140, 180, 220]) . PHP_EOL;
