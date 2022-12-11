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

    private function esVisible(int $x=0, int $y=0): bool
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

    public function obtenerMaximoArbolesVisiblesDesdeCualquierArbol(): int
    {
        $maximo = 0;
        for ($i=0; $i<$this->y; $i++) {
            for ($j=0; $j<$this->x; $j++) {
                $arboles = (int)$this->contarArbolesVisiblesDesdeArbol($i, $j);
                $maximo = ( $arboles>$maximo ? $arboles : $maximo );
            }
        }
        return $maximo;
    }

    private function contarArbolesVisiblesDesdeArbol(int $x=0, int $y=0): int
    {
        if ($x === 0 || $y === 0 || $x === $this->y-1 || $y == $this->x-1) {
            return 0;
        }

        $arbolesvisibles1 = 0;
        for ($i=$x-1; $i>=0; $i--) {
            $arbolesvisibles1++;
            if ($this->grid[$i][$y]>=$this->grid[$x][$y]) {
                break;
            }
        }

        $arbolesvisibles2 = 0;
        for ($i=$x+1; $i<$this->y; $i++) {
            $arbolesvisibles2++;
            if ($this->grid[$i][$y]>=$this->grid[$x][$y]) {
                break;
            }
        }

        $arbolesvisibles3 = 0;
        for ($j=$y-1; $j>=0; $j--) {
            $arbolesvisibles3++;
            if ($this->grid[$x][$j]>=$this->grid[$x][$y]) {
                break;
            }
        }

        $arbolesvisibles4 = 0;
        for ($j=$y+1; $j<$this->x; $j++) {
            $arbolesvisibles4++;
            if ($this->grid[$x][$j]>=$this->grid[$x][$y]) {
                break;
            }
        }

        return (int)($arbolesvisibles1 * $arbolesvisibles2 * $arbolesvisibles3 * $arbolesvisibles4);
    }
}