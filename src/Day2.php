<?php declare(strict_types=1);

namespace AdventOfCode2022;

class Day2
{
    private $tik_tak_toe = [
        ['Rock', 'Rock', 'draw'],
        ['Rock', 'Paper', 'won'],
        ['Rock', 'Scissors', 'lost'],
        ['Paper', 'Rock', 'lost'],
        ['Paper', 'Paper', 'draw'],
        ['Paper', 'Scissors', 'won'],
        ['Scissors', 'Rock', 'won'],
        ['Scissors', 'Paper', 'lost'],
        ['Scissors', 'Scissors', 'draw'],
    ];
    private $score_hands = [
        'Rock' => 1,
        'Paper' => 2,
        'Scissors' => 3,
    ];
    private $score_results = [
        'lost' => 0,
        'draw' => 3,
        'won' => 6,
    ];
    private $strategy_one = [
        'A' => 'Rock',
        'B' => 'Paper',
        'C' => 'Scissors',
        'X' => 'Rock',
        'Y' => 'Paper',
        'Z' => 'Scissors',
    ];
    private $strategy_two = [
        'A' => 'Rock',
        'B' => 'Paper',
        'C' => 'Scissors',
        'X' => 'lost',
        'Y' => 'draw',
        'Z' => 'won',
    ];
    private $lines = [];

    public function __construct(string $input='')
    {
        $this->lines = explode("\n", trim($input));
    }

    public function followStrategyOne(): int
    {
        if (empty($this->lines)) {
            return 0;
        }

        $total = 0;
        foreach ($this->lines as $line) {
            $player1 = $this->strategy_one[$line[0]];
            $player2 = $this->strategy_one[$line[2]];
            $result = $this->obtenerResultado($player1, $player2);
            $total += $this->score_hands[$player2] + $this->score_results[$result];
        }
        return $total;
    }

    private function obtenerResultado(string $player1, string $player2): string
    {
        $jugada = array_pop(array_filter($this->tik_tak_toe, function($el) use ($player1, $player2){
            return ( $el[0] === $player1 && $el[1] === $player2 ? true : false );
        }));
        return $jugada[2];
    }

    public function followStrategyTwo(): int
    {
        if (empty($this->lines)) {
            return 0;
        }

        $total = 0;
        foreach ($this->lines as $line) {
            $player1 = $this->strategy_two[$line[0]];
            $result = $this->strategy_two[$line[2]];
            $player2 = $this->obtenerJugadorDos($player1, $result);
            $total += $this->score_hands[$player2] + $this->score_results[$result];
        }
        return $total;
    }

    private function obtenerJugadorDos(string $player1, string $result): string
    {
        $jugada = array_pop(array_filter($this->tik_tak_toe, function($el) use ($player1, $result){
            return ( $el[0] === $player1 && $el[2] === $result ? true : false );
        }));
        return $jugada[1];
    }
}