<?php

include_once('vendor/autoload.php');

$input = <<<EOD
R 4
U 4
L 3
D 1
R 4
D 1
L 5
R 2
EOD;
$lines = explode("\n", $input);
// echo print_r($lines, true) . PHP_EOL;

$lines = file('input.day9.txt');
echo print_r($lines, true) . PHP_EOL;

$day9Obj = new \AdventOfCode2022\Day9(1, 0, 0);

foreach ($lines as $line) {
    if (preg_match('/([RULD]) ([0-9]+)/', $line, $matches)) {
        // echo $matches[1] . PHP_EOL;
        // echo $matches[2] . PHP_EOL;
        for ($i=0; $i<$matches[2]; $i++) {
            // echo $matches[1] . PHP_EOL;
            $day9Obj->moverCabecera($matches[1]);
        }
    }
}

echo 'Trail ' . print_r($day9Obj->getElementPaths(1), true) . PHP_EOL;
echo 'Count ' . $day9Obj->countDifferentElementPaths(1) . PHP_EOL;
