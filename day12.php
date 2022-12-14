<?php

include_once('vendor/autoload.php');

$input = <<<EOD
Sabqponm
abcryxxl
accszExk
acctuvwj
abdefghi
EOD;

$day12Obj = new \AdventOfCode2022\Day12($input);
// echo $day12Obj->obtainFewerSteps();
echo $day12Obj->prueba();
