<?php declare(strict_types=1);

namespace AdventOfCode2022;

use \Exception;

class Day12
{
    private $terreno = '';

    public function __construct(string $input='')
    {
        $this->terreno = str_replace(["\r\n", "\r", "\n"], PHP_EOL, trim($input));
    }

    public function obtainFewerSteps(): int
    {
        // return 31;
        $posicion_inicial = $this->obtenerPosicionInicial($this->terreno);
        $caminos = $this->recorrerCaminos([$this->terreno], 0, $posicion_inicial);
        return $this->obtenerMinimoNumeroPasos($caminos);
    }

    public function obtenerPosicion($terreno, $x=0, $y=0)
    {
        $offset = strpos($terreno, PHP_EOL) + strlen(PHP_EOL);
        $posicion = intval($x + $offset * $y);
        if ($x<0) {
            throw new Exception('Out of range');
        }
        if ($x>$offset-strlen(PHP_EOL)-1) {
            throw new Exception('Out of range');
        }
        if ($y<0) {
            throw new Exception('Out of range');
        }
        if ($y>strlen($terreno)/$offset) {
            throw new Exception('Out of range');
        }
        return $terreno[$posicion];
    }

    public function actualizarPosicion($terreno, $x=0, $y=0, $simbolo='.')
    {
        $offset = strpos($terreno, PHP_EOL) + strlen(PHP_EOL);
        $posicion = intval($x + $offset * $y);
        if ($x<0) {
            throw new Exception('Out of range');
        }
        if ($x>$offset-strlen(PHP_EOL)-1) {
            throw new Exception('Out of range');
        }
        if ($y<0) {
            throw new Exception('Out of range');
        }
        if ($y>strlen($terreno)/$offset) {
            throw new Exception('Out of range');
        }
        $terreno[$posicion] = $simbolo;
        return $terreno;
    }

    public function obtenerElevacion(string $caracter='')
    {
        if ($caracter === 'S') {
            return $this->obtenerElevacion('a');
        }
        if ($caracter === 'E') {
            return $this->obtenerElevacion('z');
        }
        $ord = ord($caracter);
        if ($ord>=97 && $ord<=122) {
            return $ord - 97;
        }
        throw new Exception('Character non valid');
    }

    // public function prueba()
    // {
    //     $terreno = $this->terreno;

    //     $posicion_inicial = $this->obtenerPosicionInicial($terreno);

    //     $caminos = $this->recorrerCaminos([$terreno], 0, $posicion_inicial);
    //     foreach ($caminos as $camino) {
    //         echo $terreno . PHP_EOL . PHP_EOL;
    //         echo $this->imprimirCamino($camino) . PHP_EOL . PHP_EOL;
    //         echo $this->contarPasos($camino) . PHP_EOL . PHP_EOL;
    //     }
    //     return $this->obtenerMinimoNumeroPasos($caminos);
    // }

    public function recorrerCaminos($caminos, $camino_id, $posicion)
    {
        if ($this->obtenerPosicion($caminos[$camino_id], $posicion[0], $posicion[1]) === 'E') {
            $caminos[$camino_id] = $this->actualizarPosicion($caminos[$camino_id], $posicion[0], $posicion[1], 'F');
            return $caminos;
        }
        $pasos = $this->obtenerOpcionesPasos($caminos[$camino_id], $posicion);
        if (empty($pasos)) {
            return $caminos;
        }
        $camino_actual = $caminos[$camino_id];
        foreach ($pasos as $indice=>$paso) {
            if ($indice === 0) { // Seguimos el camino en el que estamos
                $nueva_posicion = $this->calcularPosicionSegunSigno($posicion, $paso);
                $caminos[$camino_id] = $this->actualizarPosicion($camino_actual, $posicion[0], $posicion[1], $paso);
                $caminos = $this->recorrerCaminos($caminos, $camino_id, $nueva_posicion);

            } else { // Creamos otro camino nuevo para seguirlo
                $nuevo_camino_id = 1+count($caminos)-1;
                $nueva_posicion = $this->calcularPosicionSegunSigno($posicion, $paso);
                $caminos[$nuevo_camino_id] = $this->actualizarPosicion($camino_actual, $posicion[0], $posicion[1], $paso);
                $caminos = $this->recorrerCaminos($caminos, $nuevo_camino_id, $nueva_posicion);
            }
        }
        return $caminos;
    }

    public function obtenerOpcionesPasos($terreno, $posicion_actual)
    {
        $elevacion_actual = $this->obtenerElevacion($this->obtenerPosicion($this->terreno, $posicion_actual[0], $posicion_actual[1]));
        $retorno = [];
        $retorno[] = $this->puedoIrDireccion($terreno, $elevacion_actual, $this->calcularPosicionSegunSigno($posicion_actual, '^'), '^');
        $retorno[] = $this->puedoIrDireccion($terreno, $elevacion_actual, $this->calcularPosicionSegunSigno($posicion_actual, '!'), '!');
        $retorno[] = $this->puedoIrDireccion($terreno, $elevacion_actual, $this->calcularPosicionSegunSigno($posicion_actual, '<'), '<');
        $retorno[] = $this->puedoIrDireccion($terreno, $elevacion_actual, $this->calcularPosicionSegunSigno($posicion_actual, '>'), '>');
        return array_values(array_filter($retorno));
    }

    public function calcularPosicionSegunSigno($posicion, $signo)
    {
        switch ($signo) {
            case '^':
                return [$posicion[0], $posicion[1]-1];
                break;
            case '!':
                return [$posicion[0], $posicion[1]+1];
                break;
            case '<':
                return [$posicion[0]-1, $posicion[1]];
                break;
            case '>':
                return [$posicion[0]+1, $posicion[1]];
                break;
        }
    }

    public function puedoIrDireccion($terreno, $elevacion_actual, $posicion, $signo_retorno)
    {
        try {
            $letra = $this->obtenerPosicion($terreno, $posicion[0], $posicion[1]);
            if ($letra === 'S') {
                throw new Exception('No tocar la salida');
            }
            $elevacion = $this->obtenerElevacion($letra);
            if (!in_array($elevacion, [$elevacion_actual, $elevacion_actual+1])) {
                throw new Exception('No se puede subir');
            }
            return $signo_retorno;
        } catch (Exception $ex) {
            // echo $ex->getMessage() . PHP_EOL;
        }
    }

    public function imprimirCamino($terreno)
    {
        $terreno = preg_replace('/[a-z]/', '.', $terreno);
        $terreno = str_replace('!', 'v', $terreno);
        $terreno = str_replace('F', 'E', $terreno);
        echo $terreno;
    }

    public function contarPasos($camino)
    {
        $caracteres = count_chars($camino, 0);
        // echo '$caracteres ' . print_r($caracteres, true) . PHP_EOL;
        return $caracteres[ord('^')] + $caracteres[ord('!')] + $caracteres[ord('<')] + $caracteres[ord('>')];
    }

    public function obtenerMinimoNumeroPasos($caminos): int
    {
        if (empty($caminos)) {
            return 0;
        }
        $minimo = 0;
        foreach ($caminos as $camino) {
            if (strpos($camino, 'F') === false) {
                continue;
            }
            $pasos = $this->contarPasos($camino);
            $minimo = ( $minimo === 0 || $minimo > $pasos ? $pasos : $minimo );
        }
        return $minimo;
    }

    public function obtenerPosicionInicial($terreno)
    {
        $offset = strpos($terreno, PHP_EOL) + strlen(PHP_EOL);
        $posicion = strpos($terreno, 'S');
        return [$posicion%$offset, floor($posicion/$offset)];
    }
}