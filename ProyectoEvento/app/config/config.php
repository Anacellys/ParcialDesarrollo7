<?php
/**
 * Archivo de configuración principal del proyecto.
 * Define constantes base para rutas y credenciales de la base de datos.
 */

if (!defined('DB_HOST')) {
    define('DB_HOST', 'localhost');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'parcial_itech');
}
if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', '');
}

if (!defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(__DIR__, 2));
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/ParcialSoftware7/ProyectoEvento/public/');
}

if (!defined('KEYS_DIR')) {
    define('KEYS_DIR', PROJECT_ROOT . '/app/config/keys');
}

if (!defined('PRIVATE_KEY_PATH')) {
    define('PRIVATE_KEY_PATH', KEYS_DIR . '/private.pem');
}

if (!defined('PUBLIC_KEY_PATH')) {
    define('PUBLIC_KEY_PATH', KEYS_DIR . '/public.pem');
}
