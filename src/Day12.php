<?php declare(strict_types=1);

namespace AdventOfCode2022;

use \Exception;

class Day12
{
    private $terreno = '';
    private $cola = [];
    private $visitas = [];
    private $nodos = [];

    public function __construct(string $input='')
    {
        $this->terreno = preg_replace('~\R~u', "\r\n", trim($input));
    }

    public function obtainFewerSteps($posicion_inicial, $posicion_final): int
    {
        if (!$this->bfs($posicion_inicial, $posicion_final)) {
            throw new Exception(sprintf('No se puede llegar de %s a %s', json_encode($posicion_inicial), json_encode($posicion_final)));
        }
        return $this->distancia($posicion_inicial, $posicion_final);
    }

    public function obtenerPosicion(int $x, int $y): string
    {
        $offset = (int)strpos($this->terreno, PHP_EOL) + strlen(PHP_EOL);
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
        if ($y>strlen($this->terreno)/$offset) {
            throw new Exception('Out of range');
        }
        return $this->terreno[$posicion];
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

    public function puedoIrDireccion($elevacion_actual, $posicion, $signo_retorno)
    {
        try {
            $letra = $this->obtenerPosicion($posicion[0], $posicion[1]);
            if ($letra === 'S') {
                throw new Exception('No tocar la salida');
            }
            $elevacion = $this->obtenerElevacion($letra);
            if ($elevacion>$elevacion_actual+1) {
                throw new Exception('No se puede subir');
            }
            return $signo_retorno;
        } catch (Exception $ex) {
            // echo $ex->getMessage() . PHP_EOL;
        }
    }

    public function bfs($posicion_inicial, $posicion_final)
    {
        $this->cola = [];
        $this->cola[] = $posicion_inicial;

        while (count($this->cola) != 0) {
            // echo 'cola ' . count($this->cola) . ' ' . json_encode($this->cola) . PHP_EOL;
            // echo 'visitas ' . count($this->visitas) . ' ' . json_encode($this->visitas) . PHP_EOL;

            $nodo = array_shift($this->cola);
            // echo 'nodo ' . "{$nodo[0]},{$nodo[1]}" . ' ' . $this->obtenerPosicion($nodo[0], $nodo[1]) . PHP_EOL;

            $this->visitas[] = $nodo;

            $this->nodos["{$nodo[0]},{$nodo[1]}"] = [];
            $this->nodos["{$nodo[0]},{$nodo[1]}"]['nodo'] = "{$nodo[0]},{$nodo[1]}";
            $this->nodos["{$nodo[0]},{$nodo[1]}"]['distancia'] = null;
            $this->nodos["{$nodo[0]},{$nodo[1]}"]['desde'] = null;

            $pasos = $this->obtenerOpcionesPasos($nodo);
            if (empty($pasos)) {
                continue;
            }

            foreach ($pasos as $paso) {
                $nuevo_nodo = $this->calcularPosicionSegunSigno($nodo, $paso);

                $this->nodos["{$nodo[0]},{$nodo[1]}"]['hijos']["{$nuevo_nodo[0]},{$nuevo_nodo[1]}"] = 1;

                // Si el siguiente nodo es el final
                if ($nuevo_nodo[0] == $posicion_final[0] && $nuevo_nodo[1] == $posicion_final[1]) {
                    $this->visitas[] = $nuevo_nodo;

                    $this->nodos["{$nuevo_nodo[0]},{$nuevo_nodo[1]}"] = [];
                    $this->nodos["{$nuevo_nodo[0]},{$nuevo_nodo[1]}"]['nodo'] = "{$nuevo_nodo[0]},{$nuevo_nodo[1]}";
                    $this->nodos["{$nuevo_nodo[0]},{$nuevo_nodo[1]}"]['distancia'] = null;
                    $this->nodos["{$nuevo_nodo[0]},{$nuevo_nodo[1]}"]['desde'] = null;

                    return true;
                }

                // Anotar para visitar
                if (!in_array($nuevo_nodo, $this->visitas) && !in_array($nuevo_nodo, $this->cola)) {
                    $this->cola[] = $nuevo_nodo;
                }
            }
        }

        return false;
    }

    public function obtenerPosicionInicial()
    {
        $offset = strpos($this->terreno, PHP_EOL) + strlen(PHP_EOL);
        $posicion = strpos($this->terreno, 'S');
        return [intval($posicion%$offset), intval(floor($posicion/$offset))];
    }

    public function obtenerOpcionesPasos($posicion_actual)
    {
        $elevacion_actual = $this->obtenerElevacion($this->obtenerPosicion($posicion_actual[0], $posicion_actual[1]));
        $retorno = [];
        $retorno[] = $this->puedoIrDireccion($elevacion_actual, $this->calcularPosicionSegunSigno($posicion_actual, '^'), '^');
        $retorno[] = $this->puedoIrDireccion($elevacion_actual, $this->calcularPosicionSegunSigno($posicion_actual, '!'), '!');
        $retorno[] = $this->puedoIrDireccion($elevacion_actual, $this->calcularPosicionSegunSigno($posicion_actual, '<'), '<');
        $retorno[] = $this->puedoIrDireccion($elevacion_actual, $this->calcularPosicionSegunSigno($posicion_actual, '>'), '>');
        return array_values(array_filter($retorno));
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

    public function obtenerPosicionFinal()
    {
        $offset = strpos($this->terreno, PHP_EOL) + strlen(PHP_EOL);
        $posicion = strpos($this->terreno, 'E');
        return [intval($posicion%$offset), intval(floor($posicion/$offset))];
    }

    public function imprimirBfs()
    {
        $retorno = $this->terreno;
        foreach ($this->visitas as $nodo) {
            if (in_array($this->obtenerPosicion($retorno, $nodo[0], $nodo[1]), ['S', 'E'])) {
                continue;
            }
            $retorno = $this->actualizarPosicion($retorno, $nodo[0], $nodo[1], '.');
        }
        echo $retorno;
    }

    public function distancia($desde, $hasta)
    {
        $visitados = [];
        $cola = [];
        $cola[] = "{$desde[0]},{$desde[1]}";
        $this->nodos["{$desde[0]},{$desde[1]}"]['distancia'] = 0;

        while (count($cola) != 0) {

            // Coger nodo de menor distancia
            $nodo = $this->cogerNodoDistanciaMinima($cola);

            // Anotar como visitado
            $visitados[] = $nodo;

            // Datos del nodo $this->nodos[$nodo]

            // Recorrer sus hijos para meterlos en la cola
            if (empty($this->nodos[$nodo]['hijos'])) {
                continue;
            }
            foreach ($this->nodos[$nodo]['hijos'] as $hijo=>$distancia) {
                if (!isset($this->nodos[$hijo])) {
                    continue;
                }

                if (!in_array($hijo, $visitados)) {
                    $cola[] = $hijo;
                }

                if ($this->nodos[$hijo]['distancia'] == null) {
                    $this->nodos[$hijo]['distancia'] = $this->nodos[$nodo]['distancia'] + $distancia;
                    $this->nodos[$hijo]['desde'] = $nodo;
                } elseif ($this->nodos[$hijo]['distancia']>$this->nodos[$nodo]['distancia'] + $distancia) {
                    $this->nodos[$hijo]['distancia'] = $this->nodos[$nodo]['distancia'] + $distancia;
                    $this->nodos[$hijo]['desde'] = $nodo;
                }
            }
        }

        return (int)$this->nodos["{$hasta[0]},{$hasta[1]}"]['distancia'];
    }

    public function cogerNodoDistanciaMinima(&$cola)
    {
        if (count($cola) === 1) {
            return array_shift($cola);
        }
        $nodo_con_distancia_minima = null;
        foreach ($cola as $nodo) {
            if (!isset($this->nodos[$nodo])) {
                continue;
            }
            if ($nodo_con_distancia_minima === null || $nodo_con_distancia_minima['distancia']>$this->nodos[$nodo]['distancia']) {
                $nodo_con_distancia_minima = $this->nodos[$nodo];
            }
        }
        foreach ($cola as $indice=>$nodo) {
            if ($nodo === $nodo_con_distancia_minima['nodo']) {
                unset($cola[$indice]);
            }
        }
        $cola = array_values($cola);
        return $nodo_con_distancia_minima['nodo'];
    }

    public function getNodos()
    {
        return $this->nodos;
    }
}