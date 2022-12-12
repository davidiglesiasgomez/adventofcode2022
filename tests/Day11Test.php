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
        $this->assertInstanceOf(
            Day11::class,
            new Day11('')
        );
    }

    public function testComprobarCargaMonos()
    {
        // $this->markTestSkipped();

        $day11Obj = new Day11($this->input);
        $this->assertEquals(new Monkey(0, [79, 98], 'old * 19', 23, 2, 3), $day11Obj->obtenerMono(0));
        $this->assertEquals(new Monkey(1, [54, 65, 75, 74], 'old + 6', 19, 2, 0), $day11Obj->obtenerMono(1));
        $this->assertEquals(new Monkey(2, [79, 60, 97], 'old * old', 13, 1, 3), $day11Obj->obtenerMono(2));
        $this->assertEquals(new Monkey(3, [74], 'old + 3', 17, 0, 1), $day11Obj->obtenerMono(3));
    }

    /**
     * @dataProvider regalosTrasRondas
     */
    public function testComprobarEjemploTareaUno(int $rondas=0, array $regalos=[])
    {
        // $this->markTestSkipped();

        $day11Obj = new Day11($this->input);

        if (empty($rondas) || empty($regalos)) {
            return;
        }

        for ($i=1; $i<=$rondas; $i++) {
            $day11Obj->ejecutarRonda();
        }

        foreach (array_keys($regalos) as $mono_id) {
            $this->assertEquals($regalos[$mono_id], $day11Obj->comprobarMono($mono_id));
        }
    }

    public function regalosTrasRondas():array
    {
        $retorno = [
            'ronda1' => [1, [
                0 => [20, 23, 27, 26],
                1 => [2080, 25, 167, 207, 401, 1046],
                2 => [],
                3 => [],
            ]],
            'ronda2' => [2, [
                0 => [695, 10, 71, 135, 350],
                1 => [43, 49, 58, 55, 362],
                2 => [],
                3 => [],
            ]],
            'ronda3' => [3, [
                0 => [16, 18, 21, 20, 122],
                1 => [1468, 22, 150, 286, 739],
                2 => [],
                3 => [],
            ]],
            'ronda4' => [4, [
                0 => [491, 9, 52, 97, 248, 34],
                1 => [39, 45, 43, 258],
                2 => [],
                3 => [],
            ]],
            'ronda5' => [5, [
                0 => [15, 17, 16, 88, 1037],
                1 => [20, 110, 205, 524, 72],
                2 => [],
                3 => [],
            ]],
            'ronda6' => [6, [
                0 => [8, 70, 176, 26, 34],
                1 => [481, 32, 36, 186, 2190],
                2 => [],
                3 => [],
            ]],
            'ronda7' => [7, [
                0 => [162, 12, 14, 64, 732, 17],
                1 => [148, 372, 55, 72],
                2 => [],
                3 => [],
            ]],
            'ronda8' => [8, [
                0 => [51, 126, 20, 26, 136],
                1 => [343, 26, 30, 1546, 36],
                2 => [],
                3 => [],
            ]],
            'ronda9' => [9, [
                0 => [116, 10, 12, 517, 14],
                1 => [108, 267, 43, 55, 288],
                2 => [],
                3 => [],
            ]],
            'ronda10' => [10, [
                0 => [91, 16, 20, 98],
                1 => [481, 245, 22, 26, 1092, 30],
                2 => [],
                3 => [],
            ]],
            'ronda15' => [15, [
                0 => [83, 44, 8, 184, 9, 20, 26, 102],
                1 => [110, 36],
                2 => [],
                3 => [],
            ]],
            'ronda20' => [20, [
                0 => [10, 12, 14, 26, 34],
                1 => [245, 93, 53, 199, 115],
                2 => [],
                3 => [],
            ]],

        ];
        return $retorno;
    }
}
