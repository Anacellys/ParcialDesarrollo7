<?php
/**
 * Clase Validaciones.
 * Contiene métodos estáticos para validar los datos del formulario.
 */
class Validaciones
{
    public static function validarIdentidad(string $identidad): string
    {
        $identidad = trim($identidad);
        if ($identidad === '') {
            return 'La identidad es obligatoria.';
        }
        if (!preg_match('/^[0-9]{4}-[0-9]{4}-[0-9]{5}$/', $identidad)) {
            return 'La identidad debe tener el formato 0000-0000-00000.';
        }
        return '';
    }

    public static function validarNombre(string $nombre): string
    {
        $nombre = trim($nombre);
        if ($nombre === '') {
            return 'El nombre es obligatorio.';
        }
        if (mb_strlen($nombre) < 2) {
            return 'El nombre debe tener al menos 2 caracteres.';
        }
        return '';
    }

    public static function validarApellido(string $apellido): string
    {
        $apellido = trim($apellido);
        if ($apellido === '') {
            return 'El apellido es obligatorio.';
        }
        if (mb_strlen($apellido) < 2) {
            return 'El apellido debe tener al menos 2 caracteres.';
        }
        return '';
    }

    public static function validarEdad(string $edad): string
    {
        if (!is_numeric($edad) || (int)$edad <= 0) {
            return 'La edad debe ser un número mayor que cero.';
        }
        return '';
    }

    public static function validarCorreo(string $correo): string
    {
        $correo = trim($correo);
        if ($correo === '') {
            return 'El correo es obligatorio.';
        }
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            return 'El correo no tiene un formato válido.';
        }
        return '';
    }

    public static function validarCelular(string $celular): string
    {
        $celular = trim($celular);
        if ($celular === '') {
            return 'El celular es obligatorio.';
        }
        if (!preg_match('/^\+?[0-9]{8,15}$/', $celular)) {
            return 'El celular debe contener solo números y opcionalmente +.';
        }
        return '';
    }

    public static function validarSexo(string $sexo): string
    {
        $sexo = trim($sexo);
        $permitidos = ['Masculino', 'Femenino', 'Otro'];
        if (!in_array($sexo, $permitidos, true)) {
            return 'Seleccione un sexo válido.';
        }
        return '';
    }

    public static function validarPais(string $pais): string
    {
        if ($pais === '' || !is_numeric($pais)) {
            return 'Debe seleccionar un país.';
        }
        return '';
    }

    public static function validarTemas(array $temas): string
    {
        if (empty($temas)) {
            return 'Debe seleccionar al menos un tema.';
        }
        return '';
    }

    public static function validarObservaciones(string $observaciones): string
    {
        $observaciones = trim($observaciones);
        if ($observaciones === '') {
            return 'Las observaciones son obligatorias.';
        }
        if (mb_strlen($observaciones) < 5) {
            return 'Las observaciones deben tener al menos 5 caracteres.';
        }
        return '';
    }

    public static function validarFormulario(array $datos, array $temas): array
    {
        $errores = [];
        $errores['identidad'] = self::validarIdentidad($datos['identidad'] ?? '');
        $errores['nombre'] = self::validarNombre($datos['nombre'] ?? '');
        $errores['apellido'] = self::validarApellido($datos['apellido'] ?? '');
        $errores['edad'] = self::validarEdad($datos['edad'] ?? '');
        $errores['correo'] = self::validarCorreo($datos['correo'] ?? '');
        $errores['celular'] = self::validarCelular($datos['celular'] ?? '');
        $errores['sexo'] = self::validarSexo($datos['sexo'] ?? '');
        $errores['id_pais_residencia'] = self::validarPais($datos['id_pais_residencia'] ?? '');
        $errores['id_nacionalidad'] = self::validarPais($datos['id_nacionalidad'] ?? '');
        $errores['temas'] = self::validarTemas($temas);
        $errores['observacion'] = self::validarObservaciones($datos['observacion'] ?? '');

        return array_filter($errores, static fn($error) => $error !== '');
    }
}
