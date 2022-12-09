<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use AdventOfCode2022\Day9;

final class Day9Test extends TestCase
{
    public function testComprobarQueSePuedeCrear()
    {
        $this->assertInstanceOf(
            Day9::class,
            new Day9(0, 0, 0, 0)
        );
    }

    /**
     * @dataProvider posicionesInicialesProvider
     */
    public function testComprobarPosicionesIniciales(array $posicion_inicial, array $head, array $tail)
    {
        $day9Obj = new Day9(...$posicion_inicial);
        $this->assertEquals($head, $day9Obj->getHeadPosition());
        $this->assertEquals($tail, $day9Obj->getTailPosition());
    }

    public function posicionesInicialesProvider(): array
    {
        return [
            'todos ceros' => [[0, 0, 0, 0], [0, 0], [0, 0]],
            'diferentes' => [[1, 2, 3, 4], [1, 2], [3, 4]],
            'negativos' => [[-1, -2, -3, -4], [-1, -2], [-3, -4]],
        ];
    }

    /**
     * @dataProvider movimientoCabeceraProvider
     */
    public function testComprobarMovimientoCabecera(string $movimiento, array $posicion_inicial, array $posicion_final)
    {
        $day9Obj = new Day9(...$posicion_inicial);
        $day9Obj->moverCabecera($movimiento);
        $this->assertEquals($posicion_final, $day9Obj->getHeadPosition());
    }

    public function movimientoCabeceraProvider(): array
    {
        return [
            'derecha' => ['R', [0, 0, 0, 0], [1, 0]],
            'izquierda' => ['L', [0, 0, 0, 0], [-1, 0]],
            'arriba' => ['U', [0, 0, 0, 0], [0, 1]],
            'abajo' => ['D', [0, 0, 0, 0], [0, -1]],
        ];
    }

    /**
     * @dataProvider movimientoColaProvider
     */
    public function testComprobarMovimientoCola(array $posicion_inicial, array $posicion_final)
    {
        $day9Obj = new Day9(...$posicion_inicial);
        $day9Obj->moverCola();
        $this->assertEquals($posicion_final, $day9Obj->getTailPosition());
    }

    public function movimientoColaProvider(): array
    {
        return [
            'solapados' => [[0, 0, 0, 0], [0, 0]],

            'N' => [[0, 1, 0, 0], [0, 0]],
            'NE' => [[1, 1, 0, 0], [0, 0]],
            'E' => [[1, 0, 0, 0], [0, 0]],
            'SE' => [[1, -1, 0, 0], [0, 0]],
            'S' => [[0, -1, 0, 0], [0, 0]],
            'SO' => [[-1, -1, 0, 0], [0, 0]],
            'O' => [[-1, 0, 0, 0], [0, 0]],
            'NO' => [[-1, 1, 0, 0], [0, 0]],

            // ..H  -> .TH
            // T..  -> ...
            'caso 1' => [[2, 1, 0, 0], [1, 1]],

            // H..  -> HT.
            // ..T  -> ...
            'caso 2' => [[-2, 1, 0, 0], [-1, 1]],

            // T..  -> ...
            // ..H  -> .TH
            'caso 3' => [[2, -1, 0, 0], [1, -1]],

            // ..T  -> ...
            // H..  -> HT.
            'caso 4' => [[-2, -1, 0, 0], [-1, -1]],

            // .H -> .H
            // .. -> .T
            // T. -> ..
            'caso 5' => [[1, 2, 0, 0], [1, 1]],

            // H. -> H.
            // .. -> T.
            // .T -> ..
            'caso 6' => [[-1, 2, 0, 0], [-1, 1]],

            // T. -> ..
            // .. -> .T
            // .H -> .H
            'caso 7' => [[1, -2, 0, 0], [1, -1]],

            // .T -> ..
            // .. -> T.
            // H. -> H.
            'caso 8' => [[-1, -2, 0, 0], [-1, -1]],
        ];
    }

    /**
     * @dataProvider rastroColaProvider
     */
    public function testComprobarRastroCola(array $posicion_inicial, int $movimientos, array $rastro, int $posiciones)
    {
        $day9Obj = new Day9(...$posicion_inicial);
        if ($movimientos > 0) for ($i=0; $i<$movimientos; $i++) {
            $day9Obj->moverCola();
        }
        $this->assertEquals($rastro, $day9Obj->getTailTrail());
    }

    public function rastroColaProvider(): array
    {
        return [
            'caso 1' => [[0, 0, 0, 0], 0, ['0,0'], 1],
            'caso 2' => [[2, 0, 0, 0], 1, ['0,0', '1,0'], 2],
            'caso 3' => [[2, 0, 0, 0], 2, ['0,0', '1,0', '1,0'], 2],
            'caso 4' => [[2, 0, 0, 0], 3, ['0,0', '1,0', '1,0', '1,0'], 2],
        ];
    }

    /**
     * @dataProvider rastroColaProvider
     */
    public function testContabilizarRastroCola(array $posicion_inicial, int $movimientos, array $rastro, int $posiciones)
    {
        $day9Obj = new Day9(...$posicion_inicial);
        if ($movimientos > 0) for ($i=0; $i<$movimientos; $i++) {
            $day9Obj->moverCola();
        }
        $this->assertEquals($posiciones, $day9Obj->countDifferentTailTrail());
    }
}
