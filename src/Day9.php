<?php declare(strict_types=1);

namespace AdventOfCode2022;

class Day9
{
    private $elements = 0;
    private $positions = [];
    private $paths = [];

    public function __construct(int $elements=0, int $initial_x=0, int $initial_y=0)
    {
        $this->elements = $elements;
        for ($i=0; $i<=$elements; $i++) {
            $this->setElementPosition($i, $initial_x, $initial_y);
        }
    }

    public function setElementPosition(int $element=0, int $x=0, int $y=0): void
    {
        $this->positions[$element] = [$x, $y];
        $this->setElementPaths($element, $x, $y);
    }

    public function setElementPaths(int $element=0, int $x=0, int $y=0): void
    {
        $this->paths[$element][] = "{$x},{$y}";
    }

    public function getElementPosition(int $element=0): array
    {
        return $this->positions[$element];
    }

    public function moverCabecera(string $movimiento): void
    {
        $posicion = $this->getElementPosition(0);
        switch ($movimiento) {
            case 'R':
                $this->setElementPosition(0, $posicion[0]+1, $posicion[1]);
                break;
            case 'L':
                $this->setElementPosition(0, $posicion[0]-1, $posicion[1]);
                break;
            case 'U':
                $this->setElementPosition(0, $posicion[0], $posicion[1]+1);
                break;
            case 'D':
                $this->setElementPosition(0, $posicion[0], $posicion[1]-1);
                break;
        }
        for ($i=1; $i<=$this->elements; $i++) {
            $this->moverElemento($i);
        }
    }

    public function moverElemento(int $elemento): void
    {
        $posicion_elemento = $this->getElementPosition($elemento);
        $posicion_anterior = $this->getElementPosition($elemento-1);

        if ($posicion_anterior[0] == $posicion_elemento[0] && $posicion_anterior[1] == $posicion_elemento[1]) {
            return;
        }

        if (abs($posicion_anterior[0]-$posicion_elemento[0]) <= 1 && abs($posicion_anterior[1]-$posicion_elemento[1]) <= 1) {
            return;
        }

        // T.H
        if ($posicion_anterior[0] > $posicion_elemento[0] && $posicion_anterior[1] === $posicion_elemento[1]) {
            $this->setElementPosition($elemento, $posicion_elemento[0]+1, $posicion_elemento[1]);
            return;
        }

        // H.T
        if ($posicion_anterior[0] < $posicion_elemento[0] && $posicion_anterior[1] === $posicion_elemento[1]) {
            $this->setElementPosition($elemento, $posicion_elemento[0]-1, $posicion_elemento[1]);
            return;
        }

        // H
        // .
        // T
        if ($posicion_anterior[0] === $posicion_elemento[0] && $posicion_anterior[1] > $posicion_elemento[1]) {
            $this->setElementPosition($elemento, $posicion_elemento[0], $posicion_elemento[1]+1);
            return;
        }

        // T
        // .
        // H
        if ($posicion_anterior[0] === $posicion_elemento[0] && $posicion_anterior[1] < $posicion_elemento[1]) {
            $this->setElementPosition($elemento, $posicion_elemento[0], $posicion_elemento[1]-1);
            return;
        }

        if ($posicion_anterior[0] !== $posicion_elemento[0]) {
            $posicion_elemento[0] = $posicion_elemento[0] + ( $posicion_anterior[0]>$posicion_elemento[0] ? 1 : -1 );
        }
        if ($posicion_anterior[1] !== $posicion_elemento[1]) {
            $posicion_elemento[1] = $posicion_elemento[1] + ( $posicion_anterior[1]>$posicion_elemento[1] ? 1 : -1 );
        }
        $this->setElementPosition($elemento, $posicion_elemento[0], $posicion_elemento[1]);
        return;
    }

    public function getElementPaths(int $elemento): array
    {
        return $this->paths[$elemento];
    }

    public function countDifferentElementPaths(int $elemento): int
    {
        return count(array_unique($this->paths[$elemento]));
    }
}