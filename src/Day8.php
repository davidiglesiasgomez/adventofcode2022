<?php declare(strict_types=1);

namespace AdventOfCode2022;

class Day8
{
    private $grid = [];
    private $x = 0;
    private $y = 0;

    public function __construct(array $grid=[])
    {
        $this->grid = array_map(function($v){return trim($v);}, $grid);
        $this->x = ( !empty($this->grid[0]) ? strlen($this->grid[0]) : 0 );
        $this->y = count($this->grid);
    }

    public function contarVisibles()
    {
        $cuenta = 0;
        for ($i=0; $i<$this->x; $i++) {
            for ($j=0; $j<$this->y; $j++) {
                $cuenta += ( $this->esVisible($i, $j) ? 1 : 0 );
            }
        }
        return $cuenta;
    }

    private function esVisible(int $x=0, int $y=0)
    {
        if ($x === 0 || $y === 0 || $x === $this->x-1 || $y == $this->y-1) {
            return true;
        }

        $haymasalto1 = false;
        for ($i=0; $i<$x; $i++) {
            if ($this->grid[$i][$y]>=$this->grid[$x][$y]) {
                $haymasalto1 = true;
                break;
            }
        }

        $haymasalto2 = false;
        for ($i=$x+1; $i<$this->x; $i++) {
            if ($this->grid[$i][$y]>=$this->grid[$x][$y]) {
                $haymasalto2 = true;
                break;
            }
        }

        $haymasalto3 = false;
        for ($j=0; $j<$y; $j++) {
            if ($this->grid[$x][$j]>=$this->grid[$x][$y]) {
                $haymasalto3 = true;
                break;
            }
        }

        $haymasalto4 = false;
        for ($j=$y+1; $j<$this->y; $j++) {
            if ($this->grid[$x][$j]>=$this->grid[$x][$y]) {
                $haymasalto4 = true;
                break;
            }
        }

        return !($haymasalto1 && $haymasalto2 && $haymasalto3 && $haymasalto4);
    }

    public function obtenerMaximoArbolesVisiblesDesdeCualquierArbol()
    {
        $maximo = 0;
        return $maximo;
    }
}