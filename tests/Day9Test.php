<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use AdventOfCode2022\Day9;

final class Day9Test extends TestCase
{
    public function testComprobarQueSePuedeCrear()
    {
        $this->assertInstanceOf(
            Day9::class,
            new Day9(1, 0, 0)
        );
    }

    /**
     * @dataProvider posicionesInicialesProvider
     */
    public function testComprobarPosicionesIniciales(int $numero_segmentos, array $posicion_inicial, array $posiciones)
    {
        $day9Obj = new Day9($numero_segmentos, ...$posicion_inicial);
        for ($i=0; $i<=$numero_segmentos; $i++) {
            $this->assertEquals($posiciones[$i], $day9Obj->getElementPosition($i));
        }
   }

    public function posicionesInicialesProvider(): array
    {
        return [
            'caso 1' => [0, [0, 0], [[0, 0]]],
            'caso 2' => [1, [0, 0], [[0, 0], [0, 0]]],
            'caso 3' => [2, [0, 0], [[0, 0], [0, 0], [0, 0]]],
            'caso 4' => [0, [-1, -1], [[-1, -1]]],
            'caso 5' => [0, [1, 2], [[1, 2]]],
        ];
    }

    /**
     * @dataProvider movimientoCabeceraProvider
     */
    public function testComprobarMovimientoCabecera(string $movimiento, array $posicion_inicial, array $posicion_final)
    {
        $day9Obj = new Day9(0, ...$posicion_inicial);
        $day9Obj->moverCabecera($movimiento);
        $this->assertEquals($posicion_final, $day9Obj->getElementPosition(0));
    }

    public function movimientoCabeceraProvider(): array
    {
        return [
            'derecha' => ['R', [0, 0], [1, 0]],
            'izquierda' => ['L', [0, 0], [-1, 0]],
            'arriba' => ['U', [0, 0], [0, 1]],
            'abajo' => ['D', [0, 0], [0, -1]],
        ];
    }

    /**
     * @dataProvider movimientoElementoProvider
     */
    public function testComprobarMovimientoElemento(array $movimientos, array $posicion_final)
    {
        $day9Obj = new Day9(1, 0, 0);
        if (!empty($movimientos)) foreach ($movimientos as $movimiento) {
            $day9Obj->moverCabecera($movimiento);
        }
        $this->assertEquals($posicion_final, $day9Obj->getElementPosition(1));
    }

    public function movimientoElementoProvider(): array
    {
        return [
            'caso 1' => [[], [0, 0], ['0,0'], 1],

            'caso 2' => [['U'], [0, 0], ['0,0'], 1],
            'caso 3' => [['U', 'U'], [0, 1], ['0,0', '0,1'], 2],
            'caso 4' => [['U', 'U', 'R', 'R'], [1, 2], ['0,0', '0,1', '1,2'], 3],

            'caso 5' => [['D'], [0, 0], ['0,0'], 1],
            'caso 6' => [['D', 'D'], [0, -1], ['0,0', '0,-1'], 2],
            'caso 7' => [['D', 'D', 'R', 'R'], [1, -2], ['0,0', '0,-1', '1,-2'], 3],

            'caso 8' => [['R'], [0, 0], ['0,0'], 1],
            'caso 9' => [['R', 'R'], [1, 0], ['0,0', '1,0'], 2],
            'caso 10' => [['R', 'R', 'U', 'U'], [2, 1], ['0,0', '1,0', '2,1'], 3],

            'caso 11' => [['L'], [0, 0], ['0,0'], 1],
            'caso 12' => [['L', 'L'], [-1, 0], ['0,0', '-1,0'], 2],
            'caso 13' => [['L', 'L', 'U', 'U'], [-2, 1], ['0,0', '-1,0', '-2,1'], 3],
        ];
    }

    /**
     * @dataProvider movimientoElementoProvider
     */
    public function testComprobarRastroElemento(array $movimientos, array $posicion_final, array $rastro)
    {
        $day9Obj = new Day9(1, 0, 0);
        if (!empty($movimientos)) foreach ($movimientos as $movimiento) {
            $day9Obj->moverCabecera($movimiento);
        }
        $this->assertEquals($rastro, $day9Obj->getElementPaths(1));
    }

    /**
     * @dataProvider movimientoElementoProvider
     */
    public function testContabilizarRastroElemento(array $movimientos, array $posicion_final, array $rastro, int $posiciones)
    {
        $day9Obj = new Day9(1, 0, 0);
        if (!empty($movimientos)) foreach ($movimientos as $movimiento) {
            $day9Obj->moverCabecera($movimiento);
        }
        $this->assertEquals($posiciones, $day9Obj->countDifferentElementPaths(1));
    }
}
