<?php
/**
 * Modelo AreaModel.
 * Gestiona las áreas de interés registradas.
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Conexion.php';

class AreaModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getInstance()->getConnection();
    }

    public function listar(): array
    {
        $stmt = $this->pdo->query('SELECT id_area, nombre FROM areas_interes ORDER BY nombre');
        return $stmt->fetchAll();
    }
}
