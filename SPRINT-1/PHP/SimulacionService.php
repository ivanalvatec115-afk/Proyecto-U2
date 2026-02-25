<?php

namespace App\Services;

class SimulacionService
{
    /**
     * Objetivo A: Generador Congruencial Lineal [cite: 13, 14]
     * Fórmula: X_{n+1} = (aX_n + c) mod m [cite: 51]
     */
    public function generarLCG($x0, $a, $c, $m, $n)
    {
        $numeros = [];
        $xActual = $x0;

        for ($i = 0; $i < $n; $i++) {
            $xActual = ($a * $xActual + $c) % $m; // [cite: 15, 51]
            $numeros[] = round($xActual / $m, 5); // Normalización r_i [cite: 16]
        }

        return $numeros;
    }

    /**
     * Objetivo B: Prueba de Ji-Cuadrada (Uniformidad) [cite: 18, 19]
     */
    public function pruebaJiCuadrada($datos, $intervalos = 10)
    {
        $n = count($datos);
        $frecuenciaEsperada = $n / $intervalos;
        $frecuenciasObservadas = array_fill(0, $intervalos, 0);

        foreach ($datos as $numero) {
            $indice = min(floor($numero * $intervalos), $intervalos - 1);
            $frecuenciasObservadas[$indice]++;
        }

        $chi2_calculado = 0;
        foreach ($frecuenciasObservadas as $fo) {
            $chi2_calculado += pow($fo - $frecuenciaEsperada, 2) / $frecuenciaEsperada;
        }

        return [
            'observadas' => $frecuenciasObservadas,
            'esperada' => $frecuenciaEsperada,
            'chi2_calculado' => $chi2_calculado,
            'resultado' => $chi2_calculado < 16.91 // Valor crítico para alpha=0.05 y gl=9
        ];
    }
}