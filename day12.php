<?php

include_once('vendor/autoload.php');

$input = trim(file_get_contents('input/input.day12.txt'));
// $input = str_replace(["\r\n", "\r", "\n"], PHP_EOL, $input);
// echo $input;

$day12Obj = new \AdventOfCode2022\Day12($input);
echo 'Menos pasos: ' . $day12Obj->obtainFewerSteps();
