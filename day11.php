<?php

include_once('vendor/autoload.php');

$file = file_get_contents('input/input.day11.txt');

$day11Obj = new \AdventOfCode2022\Day11($file);
for ($i=1; $i<=20; $i++) {
    $day11Obj->ejecutarRonda();
}
echo 'Work ' . $day11Obj->comprobarTrabajoTopDos() . PHP_EOL;

$day11Obj = new \AdventOfCode2022\Day11($file);
for ($i=1; $i<=10000; $i++) {
    echo 'Round ' . $i . '/10000' . PHP_EOL;
    $day11Obj->ejecutarRonda(1);
}
echo 'Work ' . $day11Obj->comprobarTrabajoTopDos() . PHP_EOL;
