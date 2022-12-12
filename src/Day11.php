<?php declare(strict_types=1);

namespace AdventOfCode2022;

class Monkey
{
    private $id = 0;
    private $items = [];
    private $operation = '';
    private $divisible = 0;
    private $true = 0;
    private $false = 0;

    public function __construct($id=0, $items=[], $operation='', $divisible=1, $true=0, $false=0)
    {
        $this->id = $id;
        $this->items = $items;
        $this->operation = $operation;
        $this->divisible = $divisible;
        $this->true = $true;
        $this->false = $false;
    }

    public function ejecutarRonda()
    {
        if (empty($this->items)) {
            return;
        }

        $retorno = [];
        foreach ($this->items as $item) {
            $item = $this->actualizarItem($item);
            $retorno[( $item % $this->divisible === 0 ? $this->true : $this->false )][] = $item;
        }
        $this->items = [];
        return $retorno;
    }

    private function actualizarItem($item=0)
    {
        if (preg_match('/(old|[0-9]+) (\+|\*) (old|[0-9]+)/', $this->operation, $matches)) {
            eval('$item = ' . ( $matches[1] === 'old' ? $item : (int)$matches[1] ) . "{$matches[2]}" . ( $matches[3] === 'old' ? $item : (int)$matches[3] ) . ';');
            return intdiv($item, 3);
        }
    }

    public function insertarNuevosItems($items=[])
    {
        $this->items = array_merge($this->items, $items);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getItems()
    {
        return $this->items;
    }
}

class Day11
{
    private $monkeys = [];

    public function __construct(string $input='')
    {
        $this->monkeys = $this->procesarEntrada($input);
    }

    private function procesarEntrada(string $input='')
    {
        $lineas = explode("\n", $input);
        if (empty($lineas)) {
            return;
        }

        $id = null;
        $items = [];
        $operation = '';
        $divisible = 0;
        $true = 0;
        $false = 0;

        $retorno = [];
        foreach ($lineas as $linea) {
            if (preg_match('/Monkey ([0-9]+)\:/', $linea, $matches)) {
                $id = (int)$matches[1];
            }
            if (preg_match('/Starting items\: ([0-9 \,]+)/', $linea, $matches)) {
                $items = explode(', ', trim($matches[1]));
            }
            if (preg_match('/Operation\: new \= (.+)/', $linea, $matches)) {
                $operation = trim($matches[1]);
            }
            if (preg_match('/Test\: divisible by ([0-9]+)/', $linea, $matches)) {
                $divisible = (int)$matches[1];
            }
            if (preg_match('/If true\: throw to monkey ([0-9]+)/', $linea, $matches)) {
                $true = (int)$matches[1];
            }
            if (preg_match('/If false\: throw to monkey ([0-9]+)/', $linea, $matches)) {
                $false = (int)$matches[1];
            }

            if (strpos($linea, 'If false: throw to monkey') !== false) {
                $retorno[$id] = new Monkey($id, $items, $operation, $divisible, $true, $false);

                $id = null;
                $items = [];
                $operation = '';
                $divisible = 0;
                $true = 0;
                $false = 0;
            }
        }

        return $retorno;
    }

    public function obtenerMono($id=0): Monkey
    {
        return $this->monkeys[$id];
    }

    public function ejecutarRonda()
    {
        if (empty($this->monkeys)) {
            return;
        }

        foreach ($this->monkeys as $monkeyObj) {
            $retorno = $monkeyObj->ejecutarRonda();
            if (empty($retorno)) {
                continue;
            }
            foreach ($retorno as $monkey_id=>$items) {
                $this->monkeys[$monkey_id]->insertarNuevosItems($items);
            }
        }
    }

    public function comprobarMono(int $id=0): array
    {
        return $this->monkeys[$id]->getItems();
    }
}