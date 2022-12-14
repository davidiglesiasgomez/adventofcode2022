<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use AdventOfCode2022\Day12;

final class Day12Test extends TestCase
{
    public function testComprobarQueSePuedeCrear()
    {
        $this->assertInstanceOf(
            Day12::class,
            new Day12()
        );
    }

    public function testComprobarEjemploTareaUno()
    {
        $input = <<<EOD
Sabqponm
abcryxxl
accszExk
acctuvwj
abdefghi
EOD;
        $day12Obj = new Day12($input);
        $this->assertEquals(31, $day12Obj->obtainFewerSteps());
    }
}