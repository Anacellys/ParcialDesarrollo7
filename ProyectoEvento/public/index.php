<?php
/**
 * Punto de entrada público del sistema.
 * Muestra el formulario de inscripción y procesa el envío.
 */
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/controllers/ParticipanteController.php';

$controller = new ParticipanteController();
$mensaje = '';
$errores = [];
$datos = [];
$temasSeleccionados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resultado = $controller->guardar($_POST);
    if ($resultado['ok']) {
        $mensaje = $resultado['mensaje'];
    } else {
        $errores = $resultado['errores'];
        $datos = $resultado['datos'];
        $temasSeleccionados = $_POST['temas'] ?? [];
    }
}

$datosVista = $controller->mostrarFormulario();
$datosVista['datos'] = $datos;
$datosVista['errores'] = $errores;
$datosVista['mensaje'] = $mensaje;
$datosVista['temasSeleccionados'] = $temasSeleccionados;

extract($datosVista);
include __DIR__ . '/../app/views/formulario.php';
