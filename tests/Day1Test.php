<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use AdventOfCode2022\Day1;

final class Day1Test extends TestCase
{
    public function testComprobarQueSePuedeCrear()
    {
        $this->assertInstanceOf(
            Day1::class,
            new Day1([])
        );
    }

    public function testComprobarEjemploTareaUno()
    {
        $input = <<<EOD
1000
2000
3000

4000

5000
6000

7000
8000
9000

10000
EOD;
        $lines = explode("\n", $input);

        $day1Obj = new Day1($lines);
        $this->assertEquals(24000, $day1Obj->countMostCaloriesFromAnElf());
    }

    public function testComprobarEjemploTareaDos()
    {
        $input = <<<EOD
1000
2000
3000

4000

5000
6000

7000
8000
9000

10000
EOD;
        $lines = explode("\n", $input);

        $day1Obj = new Day1($lines);
        $this->assertEquals(45000, $day1Obj->countMostCaloriesFromTopThree());
    }
}