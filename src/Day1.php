<?php declare(strict_types=1);

namespace AdventOfCode2022;

class Day1
{
    private $elfos = [];

    public function __construct(array $lineas)
    {
        $this->elfos = $this->contabilizarElfos($lineas);
        // echo print_r($this->elfos, true);
    }

    private function contabilizarElfos(array $lineas): array
    {
        if (empty($lineas)) {
            return [];
        }

        $elfos = [];
        $elfo = 0;
        foreach ($lineas as $linea) {
            $linea = trim($linea);
            if ($linea === "") {
                $elfo++;
                continue;
            }
            if (!isset($elfos[$elfo])) {
                $elfos[$elfo] = 0;
            }
            $elfos[$elfo] += (int)$linea;
        }
        return $elfos;
    }

    public function countMostCaloriesFromAnElf()
    {
        return max($this->elfos);
    }

    public function countMostCaloriesFromTopThree()
    {
        rsort($this->elfos);
        return array_reduce(array_slice($this->elfos, 0, 3), function($carry, $item){return $carry + $item;}, 0);
    }
}