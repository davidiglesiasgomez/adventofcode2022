<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use AdventOfCode2022\Day12;

final class Day12Test extends TestCase
{
    public function testComprobarQueSePuedeCrear()
    {
        $this->assertInstanceOf(
            Day12::class,
            new Day12('')
        );
    }

    public function testObtenerPosiciones()
    {
        // $this->markTestSkipped();

        $input = <<<EOD
Sabqponm
abcryxxl
accszExk
acctuvwj
abdefghi
EOD;
        $day12Obj = new Day12($input);
        $this->assertEquals('S', $day12Obj->obtenerPosicion($input, 0, 0));
        $this->assertEquals('a', $day12Obj->obtenerPosicion($input, 1, 0));
        $this->assertEquals('b', $day12Obj->obtenerPosicion($input, 2, 0));
        $this->assertEquals('q', $day12Obj->obtenerPosicion($input, 3, 0));
        $this->assertEquals('p', $day12Obj->obtenerPosicion($input, 4, 0));
        $this->assertEquals('o', $day12Obj->obtenerPosicion($input, 5, 0));
        $this->assertEquals('n', $day12Obj->obtenerPosicion($input, 6, 0));
        $this->assertEquals('m', $day12Obj->obtenerPosicion($input, 7, 0));

        $this->assertEquals('a', $day12Obj->obtenerPosicion($input, 0, 1));
        $this->assertEquals('b', $day12Obj->obtenerPosicion($input, 1, 1));
        $this->assertEquals('c', $day12Obj->obtenerPosicion($input, 2, 1));
        $this->assertEquals('r', $day12Obj->obtenerPosicion($input, 3, 1));
        $this->assertEquals('y', $day12Obj->obtenerPosicion($input, 4, 1));
        $this->assertEquals('x', $day12Obj->obtenerPosicion($input, 5, 1));
        $this->assertEquals('x', $day12Obj->obtenerPosicion($input, 6, 1));
        $this->assertEquals('l', $day12Obj->obtenerPosicion($input, 7, 1));

        $this->assertEquals('a', $day12Obj->obtenerPosicion($input, 0, 2));
        $this->assertEquals('c', $day12Obj->obtenerPosicion($input, 1, 2));
        $this->assertEquals('c', $day12Obj->obtenerPosicion($input, 2, 2));
        $this->assertEquals('s', $day12Obj->obtenerPosicion($input, 3, 2));
        $this->assertEquals('z', $day12Obj->obtenerPosicion($input, 4, 2));
        $this->assertEquals('E', $day12Obj->obtenerPosicion($input, 5, 2));
        $this->assertEquals('x', $day12Obj->obtenerPosicion($input, 6, 2));
        $this->assertEquals('k', $day12Obj->obtenerPosicion($input, 7, 2));

        $this->assertEquals('a', $day12Obj->obtenerPosicion($input, 0, 3));
        $this->assertEquals('c', $day12Obj->obtenerPosicion($input, 1, 3));
        $this->assertEquals('c', $day12Obj->obtenerPosicion($input, 2, 3));
        $this->assertEquals('t', $day12Obj->obtenerPosicion($input, 3, 3));
        $this->assertEquals('u', $day12Obj->obtenerPosicion($input, 4, 3));
        $this->assertEquals('v', $day12Obj->obtenerPosicion($input, 5, 3));
        $this->assertEquals('w', $day12Obj->obtenerPosicion($input, 6, 3));
        $this->assertEquals('j', $day12Obj->obtenerPosicion($input, 7, 3));

        $this->assertEquals('a', $day12Obj->obtenerPosicion($input, 0, 4));
        $this->assertEquals('b', $day12Obj->obtenerPosicion($input, 1, 4));
        $this->assertEquals('d', $day12Obj->obtenerPosicion($input, 2, 4));
        $this->assertEquals('e', $day12Obj->obtenerPosicion($input, 3, 4));
        $this->assertEquals('f', $day12Obj->obtenerPosicion($input, 4, 4));
        $this->assertEquals('g', $day12Obj->obtenerPosicion($input, 5, 4));
        $this->assertEquals('h', $day12Obj->obtenerPosicion($input, 6, 4));
        $this->assertEquals('i', $day12Obj->obtenerPosicion($input, 7, 4));
    }

    public function testObtenerOutOfRangeExceptionExcederX()
    {
        // $this->markTestSkipped();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Out of range');

        $input = <<<EOD
Sabqponm
abcryxxl
accszExk
acctuvwj
abdefghi
EOD;
        $day12Obj = new Day12($input);
        $this->assertEquals('', $day12Obj->obtenerPosicion($input, 8, 0));
    }

    public function testObtenerOutOfRangeExceptionExcederY()
    {
        // $this->markTestSkipped();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Out of range');

        $input = <<<EOD
Sabqponm
abcryxxl
accszExk
acctuvwj
abdefghi
EOD;
        $day12Obj = new Day12($input);
        $this->assertEquals('', $day12Obj->obtenerPosicion($input, 0, 5));
    }

    public function testComprobarEjemploTareaUno()
    {
        $this->markTestSkipped();

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