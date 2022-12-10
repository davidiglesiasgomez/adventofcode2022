<?php

include_once('vendor/autoload.php');

$lines = file('input/input.day1.txt');
// echo print_r($lines, true) . PHP_EOL;

$day1Obj = new \AdventOfCode2022\Day1($lines);
echo 'Most from an elf ' . $day1Obj->countMostCaloriesFromAnElf() . PHP_EOL;
echo 'Top three ' . $day1Obj->countMostCaloriesFromTopThree() . PHP_EOL;
