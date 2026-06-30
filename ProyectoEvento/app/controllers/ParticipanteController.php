<?php
/**
 * Controlador ParticipanteController.
 * Procesa el formulario, valida datos y delega la persistencia al modelo.
 */
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../validations/Validaciones.php';
require_once __DIR__ . '/../sanitizers/Sanitizador.php';
require_once __DIR__ . '/../services/OpenSslService.php';
require_once __DIR__ . '/../models/PaisModel.php';
require_once __DIR__ . '/../models/AreaModel.php';
require_once __DIR__ . '/../models/ParticipanteModel.php';

class ParticipanteController
{
    private ParticipanteModel $participanteModel;
    private PaisModel $paisModel;
    private AreaModel $areaModel;
    private OpenSslService $openSslService;

    public function __construct()
    {
        $this->participanteModel = new ParticipanteModel();
        $this->paisModel = new PaisModel();
        $this->areaModel = new AreaModel();
        $this->openSslService = new OpenSslService();
    }

    public function mostrarFormulario(): array
    {
        return [
            'paises' => $this->paisModel->listar(),
            'areas' => $this->areaModel->listar(),
        ];
    }

    public function guardar(array $post): array
    {
        $errores = [];
        $temas = $post['temas'] ?? [];

        $datosLimpios = [
            'identidad' => Sanitizador::limpiarTexto($post['identidad'] ?? ''),
            'nombre' => Sanitizador::formatearTitulo($post['nombre'] ?? ''),
            'apellido' => Sanitizador::formatearTitulo($post['apellido'] ?? ''),
            'edad' => Sanitizador::limpiarEntero($post['edad'] ?? ''),
            'sexo' => Sanitizador::limpiarTexto($post['sexo'] ?? ''),
            'id_pais_residencia' => Sanitizador::limpiarEntero($post['id_pais_residencia'] ?? ''),
            'id_nacionalidad' => Sanitizador::limpiarEntero($post['id_nacionalidad'] ?? ''),
            'correo' => Sanitizador::limpiarCorreo($post['correo'] ?? ''),
            'celular' => Sanitizador::limpiarTexto($post['celular'] ?? ''),
            'observacion' => Sanitizador::limpiarTexto($post['observacion'] ?? ''),
            'fecha_registro' => Sanitizador::limpiarTexto($post['fecha_registro'] ?? date('Y-m-d H:i:s')),
        ];

        $erroresValidacion = Validaciones::validarFormulario($datosLimpios, $temas);
        if ($erroresValidacion) {
            $errores = array_merge($errores, $erroresValidacion);
        }

        if ($this->participanteModel->existeCorreo($datosLimpios['correo'])) {
            $errores['correo'] = 'El correo ya está registrado.';
        }

        if ($this->participanteModel->existeIdentidad($datosLimpios['identidad'])) {
            $errores['identidad'] = 'La identidad ya está registrada.';
        }

        if ($errores) {
            return [
                'ok' => false,
                'errores' => $errores,
                'datos' => $datosLimpios,
            ];
        }

        $firma = $this->openSslService->firmarDatos($datosLimpios);
        $this->participanteModel->guardar($datosLimpios, $temas, $firma);

        return [
            'ok' => true,
            'mensaje' => 'Participante registrado correctamente.',
        ];
    }

    public function listarReportes(): array
    {
        $registros = $this->participanteModel->listar();
        foreach ($registros as &$registro) {
            $registro['estado'] = $this->openSslService->verificarIntegridad([
                'nombre' => $registro['nombre'],
                'identidad' => $registro['identidad'],
                'correo' => $registro['correo'],
                'celular' => $registro['celular'],
                'sexo' => $registro['sexo'],
            ], $registro['firma_openssl'] ?? '');
            $registro['fecha_registro'] = $registro['fecha_registro'] ?? null;
            $registro['estado_clase'] = strpos($registro['estado'], 'Registro íntegro') !== false ? 'text-success' : 'text-danger';
        }
        return $registros;
    }
}
