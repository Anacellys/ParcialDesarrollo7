<?php
/**
 * Punto de entrada del reporte de participantes.
 */
require_once __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../app/controllers/ParticipanteController.php';

$controller = new ParticipanteController();
$registros = $controller->listarReportes();
$mensaje = '';
$errores = [];

extract(['registros' => $registros, 'mensaje' => $mensaje, 'errores' => $errores]);
include __DIR__ . '/../app/views/reporte.php';
