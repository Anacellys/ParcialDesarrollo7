<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Conexion.php';

class PaisModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getInstance()->getConnection();
    }

    public function listar(): array
    {
        $stmt = $this->pdo->query('SELECT id_pais, nombre FROM paises ORDER BY nombre');
        return $stmt->fetchAll();
    }
}
