<?php
require_once '../core/db.php';

class AdminController
{
    private $pdo;
    private $rolesCache = null;

    public function __construct()
    {
        global $pdo;
        $this->pdo = $pdo;
        // Verificar sesión al instanciar el controlador
        $this->checkSession();
    }


    private function checkSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Debug: Mostrar contenido de la sesión
        error_log("Datos de sesión: " . print_r($_SESSION, true));

        if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
            error_log("Error: Sesión no contiene user_id o username");
            throw new Exception("Acceso no autorizado. Sesión inválida.");
        }
    }

    // Método para obtener usuarios con paginación
    public function getUsuariosConRoles($limit = 3, $offset = 0)
    {
        $query = "SELECT 
                u.id, 
                u.nombre_usuario,
                u.nombre_completo,
                u.correo,
                r.nombre as rol,
                AES_DECRYPT(u.telefono, 'llave_secreta') as telefono,
                CONCAT(
                    SUBSTRING(AES_DECRYPT(u.DUI, 'llave_secreta'), 1, 8),
                    '-',
                    SUBSTRING(AES_DECRYPT(u.DUI, 'llave_secreta'), 9, 1)
                ) as DUI
              FROM usuarios u
              JOIN roles r ON u.id_rol = r.id
              ORDER BY u.id ASC
              LIMIT :limit OFFSET :offset";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Método para contar el total de usuarios
    public function getTotalUsuarios()
    {
        $query = "SELECT COUNT(*) as total FROM usuarios";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchColumn();
    }

    // Método para obtener todos los roles
    public function getRoles()
    {
        if ($this->rolesCache === null) {
            $query = "SELECT id, nombre FROM roles ORDER BY nombre";
            $stmt = $this->pdo->query($query);
            $this->rolesCache = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $this->rolesCache;
    }

    // Método para crear un nuevo usuario
    public function createUsuario($data)
    {
        try {
            // Validación de campos requeridos
            $requiredFields = ['nombre_usuario', 'contrasena', 'nombre_completo', 'correo', 'telefono', 'dui', 'rol'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    throw new Exception("El campo $field es requerido");
                }
            }
            $this->checkSession();

            // Validación de formato de DUI
            if (!preg_match('/^\d{8}-\d$/', $data['dui'])) {
                throw new Exception("Formato de DUI inválido. Use: 12345678-9");
            }

            // Validación de teléfono
            if (!preg_match('/^\d{8}$/', $data['telefono'])) {
                throw new Exception("El teléfono debe contener 8 dígitos");
            }

            // Validación de correo
            if (!filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("El correo electrónico no es válido");
            }

            // Verificar si el usuario ya existe
            $stmt = $this->pdo->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ?");
            $stmt->execute([$data['nombre_usuario']]);
            if ($stmt->fetch()) {
                throw new Exception("El nombre de usuario ya está registrado");
            }

            // Hash de la contraseña
            $hashedPassword = password_hash($data['contrasena'], PASSWORD_BCRYPT);
            if (!$hashedPassword) {
                throw new Exception("Error al generar el hash de la contraseña");
            }

            // Preparar datos para inserción
            $duiSinFormato = str_replace('-', '', $data['dui']);

            // Establecer contexto de auditoría
            $this->setAuditContext();

            // Insertar nuevo usuario
            $query = "INSERT INTO usuarios (
                nombre_usuario,
                contrasena,
                nombre_completo,
                correo,
                telefono,
                DUI,
                id_rol
              ) VALUES (
                :nombre_usuario,
                :contrasena,
                :nombre_completo,
                :correo,
                AES_ENCRYPT(:telefono, 'llave_secreta'),
                AES_ENCRYPT(:dui, 'llave_secreta'),
                :id_rol
              )";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':nombre_usuario' => $data['nombre_usuario'],
                ':contrasena' => $hashedPassword,
                ':nombre_completo' => $data['nombre_completo'],
                ':correo' => $data['correo'],
                ':telefono' => $data['telefono'],
                ':dui' => $duiSinFormato,
                ':id_rol' => $data['rol']
            ]);

            // Registrar acción de auditoría
            $this->logCustomAction('USER_CREATE', 'Creación de nuevo usuario: ' . $data['nombre_usuario']);

            return ['success' => true, 'message' => 'Usuario creado exitosamente'];
        } catch (PDOException $e) {
            $this->logError($e);
            return ['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()];
        } catch (Exception $e) {
            $this->logError($e);
            error_log("Error en createUsuario: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    // Método para actualizar un usuario existente
    public function updateUsuario($data)
    {
        try {
            // Validación de campos requeridos
            if (empty($data['id'])) {
                throw new Exception("ID de usuario no proporcionado");
            }

            // Validación de formato de DUI si se proporciona
            if (!empty($data['dui']) && !preg_match('/^\d{8}-\d$/', $data['dui'])) {
                throw new Exception("Formato de DUI inválido. Use: 12345678-9");
            }

            // Validación de teléfono si se proporciona
            if (!empty($data['telefono']) && !preg_match('/^\d{8}$/', $data['telefono'])) {
                throw new Exception("El teléfono debe contener 8 dígitos");
            }

            // Validación de correo si se proporciona
            if (!empty($data['correo']) && !filter_var($data['correo'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("El correo electrónico no es válido");
            }

            // Verificar si el usuario existe
            $stmt = $this->pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
            $stmt->execute([$data['id']]);
            if (!$stmt->fetch()) {
                throw new Exception("El usuario no existe");
            }

            // Establecer contexto de auditoría
            $this->setAuditContext();

            // Preparar los campos para actualización
            $updateFields = [];
            $params = [':id' => $data['id']];

            if (!empty($data['nombre_usuario'])) {
                // Verificar si el nuevo nombre de usuario ya existe (excluyendo al usuario actual)
                $checkStmt = $this->pdo->prepare("SELECT id FROM usuarios WHERE nombre_usuario = ? AND id != ?");
                $checkStmt->execute([$data['nombre_usuario'], $data['id']]);
                if ($checkStmt->fetch()) {
                    throw new Exception("El nombre de usuario ya está en uso por otro usuario");
                }

                $updateFields[] = "nombre_usuario = :nombre_usuario";
                $params[':nombre_usuario'] = $data['nombre_usuario'];
            }

            if (!empty($data['contrasena'])) {
                $hashedPassword = password_hash($data['contrasena'], PASSWORD_BCRYPT);
                if (!$hashedPassword) {
                    throw new Exception("Error al generar el hash de la contraseña");
                }
                $updateFields[] = "contrasena = :contrasena";
                $params[':contrasena'] = $hashedPassword;
            }

            if (!empty($data['nombre_completo'])) {
                $updateFields[] = "nombre_completo = :nombre_completo";
                $params[':nombre_completo'] = $data['nombre_completo'];
            }

            if (!empty($data['correo'])) {
                $updateFields[] = "correo = :correo";
                $params[':correo'] = $data['correo'];
            }

            if (!empty($data['telefono'])) {
                $updateFields[] = "telefono = AES_ENCRYPT(:telefono, 'llave_secreta')";
                $params[':telefono'] = $data['telefono'];
            }

            if (!empty($data['dui'])) {
                $duiSinFormato = str_replace('-', '', $data['dui']);
                $updateFields[] = "DUI = AES_ENCRYPT(:dui, 'llave_secreta')";
                $params[':dui'] = $duiSinFormato;
            }

            if (!empty($data['rol'])) {
                // Verificar si el rol existe
                $rolStmt = $this->pdo->prepare("SELECT id FROM roles WHERE id = ?");
                $rolStmt->execute([$data['rol']]);
                if (!$rolStmt->fetch()) {
                    throw new Exception("El rol seleccionado no existe");
                }

                $updateFields[] = "id_rol = :id_rol";
                $params[':id_rol'] = $data['rol'];
            }

            // Si no hay campos para actualizar
            if (empty($updateFields)) {
                throw new Exception("No se proporcionaron datos para actualizar");
            }

            // Construir la consulta SQL
            $query = "UPDATE usuarios SET " . implode(', ', $updateFields) . " WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($params);

            // Registrar acción de auditoría
            $this->logCustomAction('USER_UPDATE', 'Actualización de usuario ID: ' . $data['id']);

            return ['success' => true, 'message' => 'Usuario actualizado exitosamente'];
        } catch (PDOException $e) {
            $this->logError($e);
            return ['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()];
        } catch (Exception $e) {
            $this->logError($e);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    // Método para eliminar un usuario
    public function deleteUsuario($id)
    {
        try {
            if (empty($id)) {
                throw new Exception("ID de usuario no proporcionado");
            }

            // Verificar si el usuario existe
            $stmt = $this->pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            if (!$stmt->fetch()) {
                throw new Exception("El usuario no existe");
            }

            // Establecer contexto de auditoría
            $this->setAuditContext();

            // Eliminar el usuario
            $query = "DELETE FROM usuarios WHERE id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$id]);

            // Registrar acción de auditoría
            $this->logCustomAction('USER_DELETE', 'Eliminación de usuario ID: ' . $id);

            return ['success' => true, 'message' => 'Usuario eliminado exitosamente'];
        } catch (PDOException $e) {
            $this->logError($e);
            return ['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()];
        } catch (Exception $e) {
            $this->logError($e);
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    // Métodos para la vista
public function getIniciales($nombreCompleto) {
    $iniciales = '';
    $partesNombre = preg_split('/\s+/', trim($nombreCompleto));
    
    // Tomar primera letra de cada parte (máximo 2)
    foreach ($partesNombre as $parte) {
        if (!empty($parte)) {
            $iniciales .= strtoupper(substr($parte, 0, 1));
            if (strlen($iniciales) >= 2) break;
        }
    }
    
    return $iniciales ?: 'US'; // Default si no hay nombre
}

    public function getColorAvatar($rol)
    {
        $rol = strtolower($rol);
        return match ($rol) {
            'admin', 'administrador' => 'bg-blue-500',
            'auditor' => 'bg-purple-500',
            default => 'bg-green-500'
        };
    }

    public function getBadgeRol($rol)
    {
        $rol = strtolower($rol);
        $styles = [
            'admin' => 'bg-blue-900 text-blue-100',
            'administrador' => 'bg-blue-900 text-blue-100',
            'auditor' => 'bg-purple-900 text-purple-100',
            'usuario' => 'bg-gray-600 text-gray-100'
        ];

        $clases = $styles[$rol] ?? $styles['usuario'];
        $texto = $rol === 'administrador' ? 'admin' : $rol;

        return "<span class='{$clases} text-xs px-2 py-1 rounded-full'>" . ucfirst($texto) . "</span>";
    }

    // Métodos de auditoría
    private function setAuditContext()
    {
        try {
            // Debug: Verificar variables de sesión
            error_log("Setting audit context - User ID: " . ($_SESSION['user_id'] ?? 'NULL'));
            error_log("Username: " . ($_SESSION['username'] ?? 'NULL'));

            $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
            $userId = $_SESSION['user_id'] ?? null;
            $username = $_SESSION['username'] ?? 'sistema';

            // Verificar si el usuario existe en la base de datos
            if ($userId) {
                $stmt = $this->pdo->prepare("SELECT id FROM usuarios WHERE id = ?");
                $stmt->execute([$userId]);
                if (!$stmt->fetch()) {
                    error_log("Usuario con ID $userId no existe en la BD");
                    $userId = null;
                }
            }

            $stmt = $this->pdo->prepare("
            SET @current_user_id = :user_id,
                @current_username = :username,
                @ip_actual = :ip
        ");
            $stmt->execute([
                ':user_id' => $userId,
                ':username' => $username,
                ':ip' => $ip
            ]);

            error_log("Contexto de auditoría establecido para: $username ($userId)");
        } catch (Exception $e) {
            error_log("Error setting audit context: " . $e->getMessage());
        }
    }

    public function getUltimaActividadDetallada($userId)
    {
        $query = "SELECT 
                a.fecha,
                a.operacion,
                a.tabla_afectada,
                a.valores_antes,
                a.valores_despues,
                CASE 
                    WHEN DATE(a.fecha) = CURDATE() THEN 'Hoy'
                    WHEN DATE(a.fecha) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) THEN 'Ayer'
                    ELSE DATE_FORMAT(a.fecha, '%d/%m')
                END AS dia,
                DATE_FORMAT(a.fecha, '%H:%i') AS hora,
                CASE
                    WHEN a.operacion = 'INSERT' THEN 'Creó un registro'
                    WHEN a.operacion = 'UPDATE' THEN 'Modificó un registro'
                    WHEN a.operacion = 'DELETE' THEN 'Eliminó un registro'
                    WHEN a.operacion = 'LOGIN' THEN 'Inició sesión'
                    ELSE a.operacion
                END AS accion
              FROM auditoria a
              WHERE a.id_usuario = ?
              ORDER BY a.fecha DESC
              LIMIT 1";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    private function logCustomAction($action, $description)
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO auditoria (
                    usuario_sesion, id_usuario, ip_origen, 
                    operacion, tabla_afectada, valores_despues
                ) VALUES (
                    :username, :user_id, :ip, 
                    :action, 'usuarios', :description
                )
            ");
            $stmt->execute([
                ':username' => $_SESSION['username'] ?? 'system',
                ':user_id' => $_SESSION['user_id'] ?? 0,
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                ':action' => $action,
                ':description' => json_encode(['description' => $description])
            ]);
        } catch (Exception $e) {
            error_log("Error logging custom action: " . $e->getMessage());
        }
    }

    private function logError(Exception $e)
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO auditoria (
                    usuario_sesion, id_usuario, ip_origen,
                    operacion, tabla_afectada, valores_despues
                ) VALUES (
                    :username, :user_id, :ip,
                    'ERROR', 'system', :error_data
                )
            ");
            $stmt->execute([
                ':username' => $_SESSION['username'] ?? 'system',
                ':user_id' => $_SESSION['user_id'] ?? 0,
                ':ip' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                ':error_data' => json_encode([
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine()
                ])
            ]);
        } catch (Exception $ex) {
            error_log("Error logging error: " . $ex->getMessage());
        }
    }
}

// Manejo de las solicitudes AJAX
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $controller = new AdminController();

    switch ($_GET['action']) {
        case 'getUsuarios':
            $pagina = $_GET['pagina'] ?? 1;
            $porPagina = $_GET['porPagina'] ?? 3;
            $offset = ($pagina - 1) * $porPagina;

            $usuarios = $controller->getUsuariosConRoles($porPagina, $offset);
            $total = $controller->getTotalUsuarios();

            header('Content-Type: application/json');
            echo json_encode([
                'usuarios' => $usuarios,
                'total' => $total
            ]);
            exit;

        case 'getRoles':
            $roles = $controller->getRoles();
            header('Content-Type: application/json');
            echo json_encode($roles);
            exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action'])) {
    $controller = new AdminController();
    $input = json_decode(file_get_contents('php://input'), true);

    switch ($_GET['action']) {
        case 'createUsuario':
            echo json_encode($controller->createUsuario($input));
            exit;

        case 'updateUsuario':
            echo json_encode($controller->updateUsuario($input));
            exit;

        case 'deleteUsuario':
            echo json_encode($controller->deleteUsuario($input['id']));
            exit;
    }
}
