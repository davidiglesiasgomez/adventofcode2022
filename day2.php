<?php

include_once('vendor/autoload.php');

$file = file_get_contents('input/input.day2.txt');

$day2Obj = new \AdventOfCode2022\Day2($file);
echo 'Strategy One ' . $day2Obj->followStrategyOne() . PHP_EOL;
echo 'Strategy Two ' . $day2Obj->followStrategyTwo() . PHP_EOL;
