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
    private $checks = 0;
    private $worry_type = 1;
    private $worry_divider = 3;

    public function __construct($id=0, $items=[], $operation='', $divisible=1, $true=0, $false=0)
    {
        $this->id = $id;
        $this->items = $items;
        $this->operation = $operation;
        $this->divisible = $divisible;
        $this->true = $true;
        $this->false = $false;
    }

    public function setWorryType(int $worry_type=1)
    {
        $this->worry_type = $worry_type;
    }

    public function setWorryDivider(int $worry_divider=3)
    {
        $this->worry_divider = $worry_divider;
    }

    public function ejecutarRonda()
    {
        if (empty($this->items)) {
            return;
        }

        $retorno = [];
        foreach ($this->items as $item) {
            $item = $this->actualizarItem($item);
            $item = $this->aplicarWorry($item);
            // echo PHP_EOL . 'item ' . $item . PHP_EOL;
            // echo PHP_EOL . 'division ' . ($item % $this->divisible) . PHP_EOL;
            $retorno[( $item % $this->divisible === 0 ? $this->true : $this->false )][] = $item;
            $this->checks++;
        }
        $this->items = [];
        return $retorno;
    }

    private function actualizarItem($item=0)
    {
        if (preg_match('/(old|[0-9]+) (\+|\*) (old|[0-9]+)/', $this->operation, $matches)) {
            eval('$item = ' . ( $matches[1] === 'old' ? $item : $matches[1] ) . "{$matches[2]}" . ( $matches[3] === 'old' ? $item : $matches[3] ) . ';');
            return $item;
        }
    }

    private function aplicarWorry($item=0)
    {
        if ($this->worry_type === 1) {
            return floor($item / $this->worry_divider);
        }

        return $item % $this->worry_divider;
    }

    public function insertarNuevosItems($items=[])
    {
        $this->items = array_merge($this->items, $items);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getChecks(): int
    {
        return $this->checks;
    }

    public function getDivisible(): int
    {
        return $this->divisible;
    }
}

class Day11
{
    private $monkeys = [];
    private $worry_type = 1;
    private $worry_divider = 3;

    public function __construct(string $input='', int $worry_type=1)
    {
        $this->monkeys = $this->procesarEntrada($input);
        $this->worry_type = $worry_type;
        $this->worry_divider = $this->obtenerWorryDivider();
        foreach ($this->monkeys as &$monkeyObj) {
            $monkeyObj->setWorryType($this->worry_type);
            $monkeyObj->setWorryDivider($this->worry_divider);
        }
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

    private function obtenerWorryDivider()
    {
        if ($this->worry_type === 1) {
            return 3;
        }

        $retorno = 1;
        foreach ($this->monkeys as $monkeyObj) {
            $retorno *= $monkeyObj->getDivisible();
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

        // $worry_divider = ( $task === 1 ? 3 : array_product(array_column($this->monkeys, 'divisible')) );
        // $worry_divider = $this->obtenerWorryDivider($task);
        // echo PHP_EOL . ' $worry_divider ' . $worry_divider . PHP_EOL;

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

    public function contarManipulacionesMono(int $id=0): int
    {
        return $this->monkeys[$id]->getChecks();
    }

    public function comprobarTrabajoTopDos(): int
    {
        if (empty($this->monkeys)) {
            return 0;
        }

        $top1 = 0;
        $top2 = 0;
        foreach ($this->monkeys as $monkeyObj) {
            $checks = $monkeyObj->getChecks();
            if ($checks >= $top1) {
                $top2 = $top1;
                $top1 = $checks;
                continue;
            }
            if ($checks >= $top2) {
                $top2 = $checks;
                continue;
            }
        }
        return $top1 * $top2;
    }

    public function comprobarRegalosMono(int $id=0, array $regalos=[]): bool
    {
        if (count($this->monkeys[$id]->getItems()) !== count($regalos)) {
            return false;
        }

        foreach ($this->monkeys[$id]->getItems() as $item_id=>$item) {
            if ($item->compareTo($regalos[$item_id]) !== 0) {
                return false;
            }
        }
        return true;
    }
}