<?php declare(strict_types=1);

namespace AdventOfCode2022;

class Day10
{
    private $lineas = [];
    private $x = [0 => 1];

    public function __construct(array $lineas)
    {
        $this->lineas = $lineas;
        $this->recorrerLineas();
    }

    private function recorrerLineas()
    {
        if (empty($this->lineas)) {
            return;
        }
        $valor = end($this->x);
        foreach ($this->lineas as $linea) {
            $linea = trim($linea);
            if ($linea === 'noop') {
                $this->x[] = $valor;
            }
            if (preg_match('/addx ([\-0-9]+)/', $linea, $matches)) {
                $this->x[] = $valor;
                $this->x[] = $valor;
                $valor = $valor + (int)$matches[1];
            }
        }
    }

    public function signalStrengthAtCycle(int $cycle=0)
    {
        return $cycle * ( isset($this->x[$cycle]) ? $this->x[$cycle] : 0 );
    }

    public function sumSignalStrengthAtCycles(array $cycles=[])
    {
        if (empty($cycles)) {
            return 0;
        }
        $items = array_filter($this->x, function($k) use ($cycles) {
            return in_array($k, $cycles);
        }, ARRAY_FILTER_USE_KEY);

        $suma = 0;
        foreach ($items as $i=>$v) {
            $suma += $i * $v;
        }
        return $suma;
    }

}