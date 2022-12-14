<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use AdventOfCode2022\Day2;

final class Day2Test extends TestCase
{
    public function testComprobarQueSePuedeCrear()
    {
        $this->assertInstanceOf(
            Day2::class,
            new Day2('')
        );
    }

    public function testComprobarEjemploTareaUno()
    {
        $input = <<<EOD
A Y
B X
C Z
EOD;
        $day2Obj = new Day2($input);
        $this->assertEquals(15, $day2Obj->followStrategyOne());
    }

    public function testComprobarEjemploTareaDos()
    {
        $input = <<<EOD
A Y
B X
C Z
EOD;
        $day2Obj = new Day2($input);
        $this->assertEquals(12, $day2Obj->followStrategyTwo());
    }

}