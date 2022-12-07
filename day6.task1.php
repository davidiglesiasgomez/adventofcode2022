<?php

$pf = fopen('input.day6.txt', 'r');

$posiciones = 0;

$cola = [];

while ($char = fread($pf, 1)) {
    echo $char;

    $cola[] = $char;
    $posiciones++;

    if (count($cola)<=4) {
        continue;
    }

    array_shift($cola);

    if (count(array_unique($cola)) === 4) {
        break;
    }
}

echo PHP_EOL;
echo $posiciones . PHP_EOL;
echo print_r($cola, true) . PHP_EOL;

fclose($pf);
