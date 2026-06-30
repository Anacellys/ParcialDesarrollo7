<?php

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../config/Conexion.php';

class ParticipanteModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Conexion::getInstance()->getConnection();
    }

    public function guardar(array $datos, array $temas, string $firma): bool
    {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare('INSERT INTO inscriptores (identidad, nombre, apellido, edad, sexo, id_pais_residencia, id_nacionalidad, correo, celular, observaciones, firma_openssl, fecha_registro) VALUES (:identidad, :nombre, :apellido, :edad, :sexo, :id_pais_residencia, :id_nacionalidad, :correo, :celular, :observaciones, :firma, :fecha_registro)');
            $stmt->execute([
                ':identidad' => $datos['identidad'],
                ':nombre' => $datos['nombre'],
                ':apellido' => $datos['apellido'],
                ':edad' => (int)$datos['edad'],
                ':sexo' => $datos['sexo'],
                ':id_pais_residencia' => (int)$datos['id_pais_residencia'],
                ':id_nacionalidad' => (int)$datos['id_nacionalidad'],
                ':correo' => $datos['correo'],
                ':celular' => $datos['celular'],
                ':observaciones' => $datos['observacion'],
                ':firma' => $firma,
                ':fecha_registro' => $datos['fecha_registro'] ?? date('Y-m-d H:i:s'),
            ]);

            $idParticipante = (int)$this->pdo->lastInsertId();
            $stmtTema = $this->pdo->prepare('INSERT INTO inscriptor_area (id_inscriptor, id_area) VALUES (:id_inscriptor, :id_area)');
            foreach ($temas as $idArea) {
                $stmtTema->execute([
                    ':id_inscriptor' => $idParticipante,
                    ':id_area' => (int)$idArea,
                ]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function listar(): array
    {
        $sql = 'SELECT i.id_inscriptor, i.identidad, i.nombre, i.apellido, i.edad, i.sexo, pr.nombre AS pais, pn.nombre AS nacionalidad, i.correo, i.celular, i.observaciones, i.firma_openssl, i.fecha_registro, GROUP_CONCAT(ai.nombre ORDER BY ai.nombre SEPARATOR ", ") AS temas
                FROM inscriptores i
                LEFT JOIN inscriptor_area ia ON i.id_inscriptor = ia.id_inscriptor
                LEFT JOIN areas_interes ai ON ia.id_area = ai.id_area
                LEFT JOIN paises pr ON i.id_pais_residencia = pr.id_pais
                LEFT JOIN paises pn ON i.id_nacionalidad = pn.id_pais
                GROUP BY i.id_inscriptor, i.identidad, i.nombre, i.apellido, i.edad, i.sexo, pr.nombre, pn.nombre, i.correo, i.celular, i.observaciones, i.firma_openssl, i.fecha_registro
                ORDER BY i.id_inscriptor DESC';
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function existeCorreo(string $correo): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM inscriptores WHERE correo = :correo');
        $stmt->execute([':correo' => $correo]);
        return (int)$stmt->fetchColumn() > 0;
    }

    public function existeIdentidad(string $identidad): bool
    {
        $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM inscriptores WHERE identidad = :identidad');
        $stmt->execute([':identidad' => $identidad]);
        return (int)$stmt->fetchColumn() > 0;
    }
}
