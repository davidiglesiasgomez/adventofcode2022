<?php

include_once('vendor/autoload.php');

$lines = file('input.day9.txt');
// echo print_r($lines, true) . PHP_EOL;

$day9Obj = new \AdventOfCode2022\Day9(1, 0, 0);
$day9Obj->procesarLineas($lines);
echo 'Count ' . $day9Obj->countDifferentElementPaths(1) . PHP_EOL;

$day9Obj = new \AdventOfCode2022\Day9(9, 0, 0);
$day9Obj->procesarLineas($lines);
echo 'Count ' . $day9Obj->countDifferentElementPaths(9) . PHP_EOL;
