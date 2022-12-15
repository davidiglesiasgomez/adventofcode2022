<?php

include_once('vendor/autoload.php');

$input = file_get_contents('input/input.day12.txt');

// $input = <<<EOD
// Saa
// aaa
// aaa
// EOD;

// $input = <<<EOD
// Sabqponm
// abcryxxl
// accszExk
// acctuvwj
// abdefghi
// EOD;

$day12Obj = new \AdventOfCode2022\Day12($input);
echo 'Menos pasos: ' . $day12Obj->obtainFewerSteps();
