<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use AdventOfCode2022\Day10;

final class Day10Test extends TestCase
{
    public function testComprobarQueSePuedeCrear()
    {
        $this->assertInstanceOf(
            Day10::class,
            new Day10([])
        );
    }

    public function testComprobarEjemploTareaUno()
    {
        // $this->markTestSkipped();

        $input = <<<EOD
noop
addx 3
addx -5
EOD;
        $lines = explode("\n", $input);

        $day10Obj = new Day10($lines);
        $this->assertEquals(1, $day10Obj->signalStrengthAtCycle(1));
        $this->assertEquals(2, $day10Obj->signalStrengthAtCycle(2));
        $this->assertEquals(3, $day10Obj->signalStrengthAtCycle(3));
        $this->assertEquals(16, $day10Obj->signalStrengthAtCycle(4));
        $this->assertEquals(20, $day10Obj->signalStrengthAtCycle(5));
    }

    public function testComprobarEjemploDosTareaUno()
    {
        // $this->markTestSkipped();

        $input = <<<EOD
addx 15
addx -11
addx 6
addx -3
addx 5
addx -1
addx -8
addx 13
addx 4
noop
addx -1
addx 5
addx -1
addx 5
addx -1
addx 5
addx -1
addx 5
addx -1
addx -35
addx 1
addx 24
addx -19
addx 1
addx 16
addx -11
noop
noop
addx 21
addx -15
noop
noop
addx -3
addx 9
addx 1
addx -3
addx 8
addx 1
addx 5
noop
noop
noop
noop
noop
addx -36
noop
addx 1
addx 7
noop
noop
noop
addx 2
addx 6
noop
noop
noop
noop
noop
addx 1
noop
noop
addx 7
addx 1
noop
addx -13
addx 13
addx 7
noop
addx 1
addx -33
noop
noop
noop
addx 2
noop
noop
noop
addx 8
noop
addx -1
addx 2
addx 1
noop
addx 17
addx -9
addx 1
addx 1
addx -3
addx 11
noop
noop
addx 1
noop
addx 1
noop
noop
addx -13
addx -19
addx 1
addx 3
addx 26
addx -30
addx 12
addx -1
addx 3
addx 1
noop
noop
noop
addx -9
addx 18
addx 1
addx 2
noop
noop
addx 9
noop
noop
noop
addx -1
addx 2
addx -37
addx 1
addx 3
noop
addx 15
addx -21
addx 22
addx -6
addx 1
noop
addx 2
addx 1
noop
addx -10
noop
noop
addx 20
addx 1
addx 2
addx 2
addx -6
addx -11
noop
noop
noop
EOD;
        $lines = explode("\n", $input);

        $day10Obj = new Day10($lines);
        $this->assertEquals(420, $day10Obj->signalStrengthAtCycle(20));
        $this->assertEquals(1140, $day10Obj->signalStrengthAtCycle(60));
        $this->assertEquals(1800, $day10Obj->signalStrengthAtCycle(100));
        $this->assertEquals(2940, $day10Obj->signalStrengthAtCycle(140));
        $this->assertEquals(2880, $day10Obj->signalStrengthAtCycle(180));
        $this->assertEquals(3960, $day10Obj->signalStrengthAtCycle(220));
        $this->assertEquals(13140, $day10Obj->sumSignalStrengthAtCycles([20, 60, 100, 140, 180, 220]));
    }

    public function testComprobarEjemploDosTareaDos()
    {
        // $this->markTestSkipped();

        $input = <<<EOD
addx 15
addx -11
addx 6
addx -3
addx 5
addx -1
addx -8
addx 13
addx 4
noop
addx -1
addx 5
addx -1
addx 5
addx -1
addx 5
addx -1
addx 5
addx -1
addx -35
addx 1
addx 24
addx -19
addx 1
addx 16
addx -11
noop
noop
addx 21
addx -15
noop
noop
addx -3
addx 9
addx 1
addx -3
addx 8
addx 1
addx 5
noop
noop
noop
noop
noop
addx -36
noop
addx 1
addx 7
noop
noop
noop
addx 2
addx 6
noop
noop
noop
noop
noop
addx 1
noop
noop
addx 7
addx 1
noop
addx -13
addx 13
addx 7
noop
addx 1
addx -33
noop
noop
noop
addx 2
noop
noop
noop
addx 8
noop
addx -1
addx 2
addx 1
noop
addx 17
addx -9
addx 1
addx 1
addx -3
addx 11
noop
noop
addx 1
noop
addx 1
noop
noop
addx -13
addx -19
addx 1
addx 3
addx 26
addx -30
addx 12
addx -1
addx 3
addx 1
noop
noop
noop
addx -9
addx 18
addx 1
addx 2
noop
noop
addx 9
noop
noop
noop
addx -1
addx 2
addx -37
addx 1
addx 3
noop
addx 15
addx -21
addx 22
addx -6
addx 1
noop
addx 2
addx 1
noop
addx -10
noop
noop
addx 20
addx 1
addx 2
addx 2
addx -6
addx -11
noop
noop
noop
EOD;
        $lines = explode("\n", $input);

        $output = <<<EOD
##..##..##..##..##..##..##..##..##..##..
###...###...###...###...###...###...###.
####....####....####....####....####....
#####.....#####.....#####.....#####.....
######......######......######......####
#######.......#######.......#######.....
EOD;

        $day10Obj = new Day10($lines);
        $this->assertEquals($output, $day10Obj->renderScreen());
    }
}