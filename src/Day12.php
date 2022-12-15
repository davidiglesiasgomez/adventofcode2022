<?php declare(strict_types=1);

namespace AdventOfCode2022;

use \Exception;

class Day12
{
    private $terreno = '';
    private $camino_id = 0;
    private $minimo_numero_pasos = 0;

    public function __construct(string $input='')
    {
        $this->terreno = preg_replace('~\R~u', "\r\n", trim($input));
    }

    public function obtainFewerSteps(): int
    {
        $posicion_inicial = $this->obtenerPosicionInicial($this->terreno);
        $this->recorrerCaminos([$this->terreno], $this->camino_id, $posicion_inicial);
        return $this->minimo_numero_pasos;
    }

    public function obtenerPosicion(string $terreno, int $x, int $y): string
    {
        $offset = (int)strpos($terreno, PHP_EOL) + strlen(PHP_EOL);
        $posicion = $x + $offset * $y;
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

    public function actualizarPosicion(string $terreno, int $x, int $y, string $simbolo='.'): string
    {
        $offset = (int)strpos($terreno, PHP_EOL) + strlen(PHP_EOL);
        $posicion = $x + $offset * $y;
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

    public function recorrerCaminos($caminos, $camino_id, $posicion)
    {
        if ($this->obtenerPosicion($caminos[$camino_id], $posicion[0], $posicion[1]) === 'E') {
            $caminos[$camino_id] = $this->actualizarPosicion($caminos[$camino_id], $posicion[0], $posicion[1], 'F');

            $pasos = $this->contarPasos($caminos[$camino_id]);
            $this->actualizarMinimoNumeroPasos($pasos);

            echo 'camino_id ' . $camino_id . ' llego al final con ' . $pasos . ' pasos' . PHP_EOL;
            echo $this->imprimirCamino($caminos[$camino_id], true) . PHP_EOL . PHP_EOL;

            unset($caminos[$camino_id]);
            return $caminos;
        }
        $pasos = $this->obtenerOpcionesPasos($caminos[$camino_id], $posicion);
        if (empty($pasos)) {
            echo 'camino_id ' . $camino_id . ' sin mas pasos' . PHP_EOL;
            // echo $this->imprimirCamino($caminos[$camino_id], true) . PHP_EOL . PHP_EOL;
            unset($caminos[$camino_id]);
            return $caminos;
        }
        $camino_actual = $caminos[$camino_id];
        foreach ($pasos as $indice=>$paso) {
            if ($indice === 0) { // Seguimos el camino en el que estamos
                $nueva_posicion = $this->calcularPosicionSegunSigno($posicion, $paso);
                $caminos[$camino_id] = $this->actualizarPosicion($camino_actual, $posicion[0], $posicion[1], $paso);
                $caminos = $this->recorrerCaminos($caminos, $camino_id, $nueva_posicion);

            } else { // Creamos otro camino nuevo para seguirlo
                $this->camino_id++;
                $nueva_posicion = $this->calcularPosicionSegunSigno($posicion, $paso);
                $caminos[$this->camino_id] = $this->actualizarPosicion($camino_actual, $posicion[0], $posicion[1], $paso);
                $caminos = $this->recorrerCaminos($caminos, $this->camino_id, $nueva_posicion);
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

    public function imprimirCamino($terreno, $pretty=false)
    {
        if ($pretty) {
            $terreno = preg_replace('/[a-z]/', '.', $terreno);
            $terreno = str_replace('!', 'v', $terreno);
            $terreno = str_replace('F', 'E', $terreno);
        }
        echo $terreno;
    }

    public function contarPasos($camino)
    {
        $caracteres = count_chars($camino, 0);
        return $caracteres[ord('^')] + $caracteres[ord('!')] + $caracteres[ord('<')] + $caracteres[ord('>')];
    }

    public function obtenerPosicionInicial($terreno)
    {
        $offset = strpos($terreno, PHP_EOL) + strlen(PHP_EOL);
        $posicion = strpos($terreno, 'S');
        return [intval($posicion%$offset), intval(floor($posicion/$offset))];
    }

    public function actualizarMinimoNumeroPasos(int $pasos): void
    {
        $this->minimo_numero_pasos = ( $this->minimo_numero_pasos === 0 || $this->minimo_numero_pasos > $pasos ? $pasos : $this->minimo_numero_pasos );
    }
}