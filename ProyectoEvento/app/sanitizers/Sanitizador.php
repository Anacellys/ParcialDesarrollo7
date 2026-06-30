<?php
/**
 * Clase Sanitizador.
 * Aplica limpieza de datos y protección básica contra XSS/SQL Injection.
 */
class Sanitizador
{
    public static function limpiarTexto(string $valor): string
    {
        $valor = trim($valor);
        $valor = strip_tags($valor);
        $valor = preg_replace('/\s+/', ' ', $valor) ?? $valor;
        return $valor;
    }

    public static function limpiarCorreo(string $valor): string
    {
        $valor = self::limpiarTexto($valor);
        return strtolower($valor);
    }

    public static function limpiarEntero(string $valor): int
    {
        $valor = trim((string)$valor);
        if ($valor === '') {
            return 0;
        }

        $valor = preg_replace('/[^0-9]/', '', $valor) ?? '';
        return (int)$valor;
    }

    public static function limpiarArray(array $valores): array
    {
        return array_map(static fn($valor) => self::limpiarTexto((string)$valor), $valores);
    }

    public static function formatearTitulo(string $valor): string
    {
        $valor = self::limpiarTexto($valor);
        return mb_convert_case($valor, MB_CASE_TITLE, 'UTF-8');
    }
}
