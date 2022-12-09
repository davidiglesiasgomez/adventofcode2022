<?php declare(strict_types=1);

namespace AdventOfCode2022;

class Day9
{
    private $head = [null, null];
    private $tail = [null, null];
    private $trail = [];

    public function __construct(int $head_x=0, int $head_y=0, int $tail_x=0, int $tail_y=0)
    {
        $this->head = [$head_x, $head_y];
        $this->tail = [$tail_x, $tail_y];
        $this->setTailTrail($this->tail);
    }

    public function getHeadPosition(): array
    {
        return $this->head;
    }

    public function getTailPosition(): array
    {
        return $this->tail;
    }

    public function moverCabecera(string $movimiento)
    {
        switch ($movimiento) {
            case 'R':
                $this->head = [$this->head[0]+1, $this->head[1]];
                break;
            case 'L':
                $this->head = [$this->head[0]-1, $this->head[1]];
                break;
            case 'U':
                $this->head = [$this->head[0], $this->head[1]+1];
                break;
            case 'D':
                $this->head = [$this->head[0], $this->head[1]-1];
                break;
        }
    }

    public function moverCola()
    {
        if ($this->head[0] == $this->tail[0] && $this->head[1] == $this->tail[1]) {
            $this->setTailTrail($this->tail);
            return;
        }

        if (abs($this->head[0]-$this->tail[0]) <= 1 && abs($this->head[1]-$this->tail[1]) <= 1) {
            $this->setTailTrail($this->tail);
            return;
        }

        // T.H
        if ($this->head[0] > $this->tail[0] && $this->head[1] === $this->tail[1]) {
            $this->tail[0] = $this->tail[0]+1;
            $this->setTailTrail($this->tail);
            return;
        }

        // H.T
        if ($this->head[0] < $this->tail[0] && $this->head[1] === $this->tail[1]) {
            $this->tail[0] = $this->tail[0]-1;
            $this->setTailTrail($this->tail);
            return;
        }

        // H
        // .
        // T
        if ($this->head[0] === $this->tail[0] && $this->head[1] > $this->tail[1]) {
            $this->tail[1] = $this->tail[1]+1;
            $this->setTailTrail($this->tail);
            return;
        }

        // T
        // .
        // H
        if ($this->head[0] === $this->tail[0] && $this->head[1] < $this->tail[1]) {
            $this->tail[1] = $this->tail[1]-1;
            $this->setTailTrail($this->tail);
            return;
        }

        if ($this->head[0] !== $this->tail[0]) {
            $this->tail[0] = $this->tail[0] + ( $this->head[0]>$this->tail[0] ? 1 : -1 );
        }
        if ($this->head[1] !== $this->tail[1]) {
            $this->tail[1] = $this->tail[1] + ( $this->head[1]>$this->tail[1] ? 1 : -1 );
        }

        $this->setTailTrail($this->tail);
        return;
    }

    public function getTailTrail()
    {
        return $this->trail;
    }

    public function setTailTrail(array $position=[])
    {
        $this->trail[] = $position[0] . ',' . $position[1];
    }

    public function countDifferentTailTrail()
    {
        return count(array_unique($this->trail));
    }
}