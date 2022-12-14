<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use AdventOfCode2022\Day11;
use AdventOfCode2022\Monkey;

final class Day11Test extends TestCase
{
    public function setUp(): void
    {
        $this->input = <<<EOD
Monkey 0:
    Starting items: 79, 98
    Operation: new = old * 19
    Test: divisible by 23
    If true: throw to monkey 2
    If false: throw to monkey 3

Monkey 1:
    Starting items: 54, 65, 75, 74
    Operation: new = old + 6
    Test: divisible by 19
    If true: throw to monkey 2
    If false: throw to monkey 0

Monkey 2:
    Starting items: 79, 60, 97
    Operation: new = old * old
    Test: divisible by 13
    If true: throw to monkey 1
    If false: throw to monkey 3

Monkey 3:
    Starting items: 74
    Operation: new = old + 3
    Test: divisible by 17
    If true: throw to monkey 0
    If false: throw to monkey 1
EOD;
    }

    public function testComprobarQueSePuedeCrear()
    {
        // $this->markTestSkipped();

        $this->assertInstanceOf(
            Day11::class,
            new Day11('', 1)
        );
    }

    public function testComprobarCargaMonos()
    {
        // $this->markTestSkipped();

        $day11Obj = new Day11($this->input, 1);

        $day11Obj->obtenerMono(0);

        $this->assertEquals(new Monkey(0, [79, 98], 'old * 19', 23, 2, 3), $day11Obj->obtenerMono(0));
        $this->assertEquals(new Monkey(1, [54, 65, 75, 74], 'old + 6', 19, 2, 0), $day11Obj->obtenerMono(1));
        $this->assertEquals(new Monkey(2, [79, 60, 97], 'old * old', 13, 1, 3), $day11Obj->obtenerMono(2));
        $this->assertEquals(new Monkey(3, [74], 'old + 3', 17, 0, 1), $day11Obj->obtenerMono(3));
    }

    public function testComprobarTotalesTareaUno()
    {
        // $this->markTestSkipped();

        $day11Obj = new Day11($this->input, 1);
        for ($i=1; $i<=20; $i++) {
            $day11Obj->ejecutarRonda();
        }
        $this->assertEquals(101, $day11Obj->contarManipulacionesMono(0));
        $this->assertEquals(95, $day11Obj->contarManipulacionesMono(1));
        $this->assertEquals(7, $day11Obj->contarManipulacionesMono(2));
        $this->assertEquals(105, $day11Obj->contarManipulacionesMono(3));
    }

    public function testComprobarTrabajoTareaUno()
    {
        // $this->markTestSkipped();

        $day11Obj = new Day11($this->input, 1);
        for ($i=1; $i<=20; $i++) {
            $day11Obj->ejecutarRonda();
        }
        $this->assertEquals(10605, $day11Obj->comprobarTrabajoTopDos());
    }

    /**
     * @dataProvider comprobacionesTrasRondas
     */
    public function testComprobarTotalesTareaDos(int $numero_rondas=0, array $rondas=[])
    {
        // $this->markTestSkipped();

        $day11Obj = new Day11($this->input, 2);

        if (empty($numero_rondas)) {
            return;
        }

        for ($i=1; $i<=$numero_rondas; $i++) {
            $day11Obj->ejecutarRonda(2);
            if (empty($rondas[$i])) {
                continue;
            }
            foreach (array_keys($rondas[$i]) as $mono_id) {
                $this->assertEquals($rondas[$i][$mono_id], $day11Obj->contarManipulacionesMono($mono_id));
            }
        }
    }

    public function comprobacionesTrasRondas(): array
    {
        $retorno = [
            'rondas' => [10000, [
                1 => [
                    0 => 2,
                    1 => 4,
                    2 => 3,
                    3 => 6,
                ],
                20 => [
                    0 => 99,
                    1 => 97,
                    2 => 8,
                    3 => 103,
                ],
                1000 => [
                    0 => 5204,
                    1 => 4792,
                    2 => 199,
                    3 => 5192,
                ],
                2000 => [
                    0 => 10419,
                    1 => 9577,
                    2 => 392,
                    3 => 10391,
                ],
                3000 => [
                    0 => 15638,
                    1 => 14358,
                    2 => 587,
                    3 => 15593,
                ],
                4000 => [
                    0 => 20858,
                    1 => 19138,
                    2 => 780,
                    3 => 20797,
                ],
                5000 => [
                    0 => 26075,
                    1 => 23921,
                    2 => 974,
                    3 => 26000,
                ],
                6000 => [
                    0 => 31294,
                    1 => 28702,
                    2 => 1165,
                    3 => 31204,
                ],
                7000 => [
                    0 => 36508,
                    1 => 33488,
                    2 => 1360,
                    3 => 36400,
                ],
                8000 => [
                    0 => 41728,
                    1 => 38268,
                    2 => 1553,
                    3 => 41606,
                ],
                9000 => [
                    0 => 46945,
                    1 => 43051,
                    2 => 1746,
                    3 => 46807,
                ],
                10000 => [
                    0 => 52166,
                    1 => 47830,
                    2 => 1938,
                    3 => 52013,
                ],
            ]],
        ];
        return $retorno;
    }

    public function testComprobarTrabajoTareaDos()
    {
        // $this->markTestSkipped();

        $day11Obj = new Day11($this->input, 2);
        for ($i=1; $i<=10000; $i++) {
            $day11Obj->ejecutarRonda(2);
        }

        $this->assertEquals(2713310158, $day11Obj->comprobarTrabajoTopDos());
    }
}
