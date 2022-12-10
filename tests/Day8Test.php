<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use AdventOfCode2022\Day8;

final class Day8Test extends TestCase
{
    public function testComprobarQueSePuedeCrear()
    {
        $this->assertInstanceOf(
            Day8::class,
            new Day8([])
        );
    }

    public function testComprobarEjemploTareaUno()
    {
        $input = <<<EOD
30373
25512
65332
33549
35390
EOD;
        $lines = explode("\n", $input);

        $day8Obj = new Day8($lines);
        $this->assertEquals(21, $day8Obj->contarVisibles());
    }

    public function testComprobarEjemploTareaDos()
    {
        $input = <<<EOD
30373
25512
65332
33549
35390
EOD;
        $lines = explode("\n", $input);

        $day8Obj = new Day8($lines);
        $this->assertEquals(8, $day8Obj->obtenerMaximoArbolesVisiblesDesdeCualquierArbol());
    }
}