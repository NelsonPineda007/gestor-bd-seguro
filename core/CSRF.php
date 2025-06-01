<?php
class CSRF {
    private static $tokenName = 'csrf_token';
    private static $tokenExpireName = 'csrf_token_expire';
    private static $tokenLifetime = 3600;
    private static $logFile = __DIR__.'/csrf_log.txt';

    private static function log($message, $data = []) {
        $logMessage = "[".date('Y-m-d H:i:s')."] ".$message.PHP_EOL;
        if (!empty($data)) {
            $logMessage .= "Datos: ".json_encode($data, JSON_PRETTY_PRINT).PHP_EOL;
        }
        file_put_contents(self::$logFile, $logMessage, FILE_APPEND);
    }

    public static function iniciarSesion() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
            self::log("Sesión iniciada", ['session_id' => session_id()]);
        }
    }

    public static function generarToken() {
        self::iniciarSesion();
        
        // Eliminar token anterior si existe
        self::eliminarToken();
        
        // Generar nuevo token
        $token = bin2hex(random_bytes(32));
        $_SESSION[self::$tokenName] = $token;
        $_SESSION[self::$tokenExpireName] = time() + self::$tokenLifetime;
        
        self::log("Token generado", [
            'token_hash' => hash('sha256', $token),
            'expira' => date('Y-m-d H:i:s', $_SESSION[self::$tokenExpireName])
        ]);
        
        return $token;
    }
    
    public static function validarToken($tokenRecibido) {
        self::iniciarSesion();
        
        $validationData = [
            'token_recibido_hash' => hash('sha256', $tokenRecibido),
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'DESCONOCIDA'
        ];

        // Verificar existencia del token
        if (empty($_SESSION[self::$tokenName])) {
            self::log("Validación fallida: No hay token en sesión", $validationData);
            return false;
        }
        
        $validationData['token_esperado_hash'] = hash('sha256', $_SESSION[self::$tokenName]);

        // Verificar expiración
        if (time() > $_SESSION[self::$tokenExpireName]) {
            self::log("Validación fallida: Token expirado", $validationData);
            self::eliminarToken();
            return false;
        }
        
        // Comparación segura
        if (!hash_equals($_SESSION[self::$tokenName], $tokenRecibido)) {
            self::log("Validación fallida: Token no coincide", $validationData);
            return false;
        }
        
        self::log("Validación exitosa", $validationData);
        self::eliminarToken();
        return true;
    }
    
    public static function eliminarToken() {
        if (isset($_SESSION[self::$tokenName])) {
            self::log("Token eliminado de sesión");
            unset($_SESSION[self::$tokenName]);
            unset($_SESSION[self::$tokenExpireName]);
        }
    }
    
    public static function getTokenField() {
        return '<input type="hidden" name="'.self::$tokenName.'" value="'.self::generarToken().'">';
    }
    
    public static function clearLogs() {
        if (file_exists(self::$logFile)) {
            unlink(self::$logFile);
        }
    }
}