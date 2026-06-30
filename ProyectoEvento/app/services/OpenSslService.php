<?php
/**
 * Servicio OpenSSL.
 * Genera una firma digital para validar la integridad de los registros.
 */
class OpenSslService
{
    public function __construct()
    {
        if (!function_exists('openssl_sign')) {
            throw new RuntimeException('La extensión OpenSSL no está disponible en este entorno.');
        }

        if (!is_dir(KEYS_DIR)) {
            mkdir(KEYS_DIR, 0777, true);
        }

        if (!file_exists(PRIVATE_KEY_PATH) || !file_exists(PUBLIC_KEY_PATH)) {
            $this->generarParDeClaves();
        }
    }

    private function generarParDeClaves(): void
    {
        $config = [
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ];

        $rutaConfig = $this->obtenerRutaConfigOpenSsl();
        if ($rutaConfig !== null) {
            $config['config'] = $rutaConfig;
        }

        $res = openssl_pkey_new($config);
        if ($res === false) {
            $errores = [];
            while (($error = openssl_error_string()) !== false) {
                $errores[] = $error;
            }
            throw new RuntimeException('No se pudo generar el par de claves OpenSSL: ' . implode(' | ', $errores));
        }

        $exportado = openssl_pkey_export_to_file($res, PRIVATE_KEY_PATH, null, $config);
        if ($exportado === false) {
            $errores = [];
            while (($error = openssl_error_string()) !== false) {
                $errores[] = $error;
            }
            throw new RuntimeException('No se pudo exportar la clave privada OpenSSL: ' . implode(' | ', $errores));
        }

        $details = openssl_pkey_get_details($res);
        if ($details === false || empty($details['key'])) {
            throw new RuntimeException('No se pudo obtener la clave pública OpenSSL desde el par generado.');
        }

        file_put_contents(PUBLIC_KEY_PATH, $details['key']);
    }

    private function obtenerRutaConfigOpenSsl(): ?string
    {
        $candidatas = [
            'C:/Program Files/Common Files/SSL/openssl.cnf',
            'C:\\Program Files\\Common Files\\SSL\\openssl.cnf',
            'C:/openssl.cnf',
            'openssl.cnf',
        ];

        foreach ($candidatas as $ruta) {
            if (is_file($ruta)) {
                return $ruta;
            }
        }

        return null;
    }

    private function cargarClavePrivada()
    {
        if (!file_exists(PRIVATE_KEY_PATH)) {
            $this->generarParDeClaves();
        }

        $privateKey = openssl_pkey_get_private(file_get_contents(PRIVATE_KEY_PATH));
        if ($privateKey === false) {
            $this->generarParDeClaves();
            $privateKey = openssl_pkey_get_private(file_get_contents(PRIVATE_KEY_PATH));
        }

        if ($privateKey === false) {
            throw new RuntimeException('No se pudo cargar la clave privada OpenSSL.');
        }

        return $privateKey;
    }

    private function cargarClavePublica()
    {
        if (!file_exists(PUBLIC_KEY_PATH)) {
            $this->generarParDeClaves();
        }

        $publicKey = openssl_pkey_get_public(file_get_contents(PUBLIC_KEY_PATH));
        if ($publicKey === false) {
            $this->generarParDeClaves();
            $publicKey = openssl_pkey_get_public(file_get_contents(PUBLIC_KEY_PATH));
        }

        if ($publicKey === false) {
            throw new RuntimeException('No se pudo cargar la clave pública OpenSSL.');
        }

        return $publicKey;
    }

    public function firmarDatos(array $datos): string
    {
        $payload = implode('|', [
            $datos['nombre'] ?? '',
            $datos['identidad'] ?? '',
            $datos['correo'] ?? '',
            $datos['celular'] ?? '',
            $datos['sexo'] ?? '',
        ]);

        $privateKey = $this->cargarClavePrivada();
        openssl_sign($payload, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        return base64_encode($signature);
    }

    public function verificarIntegridad(array $datos, string $firma): string
    {
        $payload = implode('|', [
            $datos['nombre'] ?? '',
            $datos['identidad'] ?? '',
            $datos['correo'] ?? '',
            $datos['celular'] ?? '',
            $datos['sexo'] ?? '',
        ]);

        $publicKey = $this->cargarClavePublica();
        $firmaBinaria = base64_decode($firma, true);

        if ($firmaBinaria === false) {
            return '🔴 Registro alterado';
        }

        $resultado = openssl_verify($payload, $firmaBinaria, $publicKey, OPENSSL_ALGO_SHA256);
        return $resultado === 1 ? '🟢 Registro íntegro' : '🔴 Registro alterado';
    }
}
