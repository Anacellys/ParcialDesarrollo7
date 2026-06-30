<?php

class TextoHelper
{
    public static function formatearFecha(?string $fecha): string
    {
        if ($fecha === null || $fecha === '') {
            return 'Sin fecha';
        }

        $fechaObj = new DateTime($fecha);
        return $fechaObj->format('d/m/Y H:i:s');
    }

    public static function limpiarTextoSimple(string $valor): string
    {
        $valor = trim($valor);
        $valor = preg_replace('/\s+/', ' ', $valor) ?? $valor;
        return $valor;
    }
}
