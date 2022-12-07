<?php

$lines = file('input.day5.txt');
// echo print_r($lines, true) . PHP_EOL;

$columns = [];
$moves = [];

foreach ($lines as $line) {
	if (preg_match('/(\[[A-Z]\]|   ) (\[[A-Z]\]|   ) (\[[A-Z]\]|   ) (\[[A-Z]\]|   ) (\[[A-Z]\]|   ) (\[[A-Z]\]|   ) (\[[A-Z]\]|   ) (\[[A-Z]\]|   ) (\[[A-Z]\]|   )/', $line, $matches)) {
		// echo print_r($matches, true) . PHP_EOL;
		for ($i=1; $i<=9; $i++) {
			if (!is_array($columns[$i])) {
				$columns[$i] = [];
			}
			if (trim($matches[$i]) == '') {
				continue;
			}
			array_unshift($columns[$i], $matches[$i]);
		}
	}

	if (preg_match('/move ([0-9]+) from ([0-9]) to ([0-9])/', $line, $matches)) {
		$moves[] = $matches[0];
	}
}

echo print_r($columns, true) . PHP_EOL;

echo 'inicial' . PHP_EOL;

echo print_stack($columns) . PHP_EOL;

task1($columns, $moves);
// task2($columns, $moves);

echo top_columns($columns);

function task1(&$columns, $moves)
{
	foreach ($moves as $move) {
		list(, $amount, , $from, , $to) = explode(' ', $move);

		echo $amount . ': ' . $from . ' -> ' . $to . PHP_EOL;

		for ($i=1; $i<=$amount; $i++) {
			$box = array_pop($columns[$from]);
			array_push($columns[$to], $box);
		}

		echo print_stack($columns) . PHP_EOL;
	}
}

function task2(&$columns, $moves)
{
	foreach ($moves as $move) {
		list(, $amount, , $from, , $to) = explode(' ', $move);

		echo $amount . ': ' . $from . ' -> ' . $to . PHP_EOL;

		$boxes = [];
		for ($i=1; $i<=$amount; $i++) {
			$box = array_pop($columns[$from]);
			array_unshift($boxes, $box);
		}
		array_push($columns[$to], ...$boxes);

		echo print_stack($columns) . PHP_EOL;
	}
}

function print_stack($columns)
{
	$retorno = '    ';
	for ($i=1; $i<=count($columns); $i++) {
		$retorno .= ' ' . $i . '  ';
	}
	$retorno .= PHP_EOL;
	$row = 0;
	while (true) {
		$linea = '';
		$flag = false;
		for ($i=1; $i<=count($columns); $i++) {
			$linea .= ( isset($columns[$i][$row]) ? $columns[$i][$row] : '   ' ) . ' ';
			$flag = ( isset($columns[$i][$row]) ? true : $flag );
		}
		if (!$flag) {
			break;
		}
		$retorno = str_pad(($row + 1), 3, ' ', STR_PAD_LEFT) . ' ' . $linea . PHP_EOL . $retorno;
		$row++;
	}
	return $retorno;
}

function top_columns($columns)
{
	$retorno = '';
	for ($i=1; $i<=count($columns); $i++) {
		$box = array_pop($columns[$i]);
		$retorno .= str_replace(['[', ']'], '', $box);
	}
	return $retorno;
}