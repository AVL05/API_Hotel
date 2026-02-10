<?php
session_start();
require_once __DIR__ . '/config/db.php';

header("Content-Type: application/json");
$db = conectar();
$metodo = $_SERVER['REQUEST_METHOD'];
$accion = $_GET['action'] ?? '';

// Logout
if ($accion === 'logout') {
    session_destroy();
    header("Location: index.php");
    exit;
}

// LOGIN
if ($accion === 'login' && $metodo === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $stmt = $db->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$input['email']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($input['password'], $user['password'])) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_nombre'] = $user['nombre'];
        echo json_encode(["status" => "success", "mensaje" => "Acceso concedido"]);
    } else {
        http_response_code(401);
        echo json_encode(["error" => "Credenciales incorrectas"]);
    }
    exit;
}

// PROTECCIÓN: Solo POST (crear reserva) es público.
if (($metodo === 'GET' || $metodo === 'PUT' || $metodo === 'DELETE') && $accion !== 'login') {
    if (!isset($_SESSION['admin_id'])) {
        http_response_code(401);
        exit(json_encode(["error" => "No autorizado"]));
    }
}

switch ($metodo) {
    case 'GET':
        $sql = "SELECT r.id, u.nombre, u.apellidos, r.fecha_entrada, r.fecha_salida, r.habitacion_numero, h.nombre as nombre_habitacion FROM reservas r INNER JOIN usuarios u ON r.usuario_id = u.id LEFT JOIN habitaciones h ON r.habitacion_id = h.id ORDER BY r.id DESC";
        $stmt = $db->query($sql);
        $reservas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Map habitacion_numero to habitacion for compatibility if needed, or update frontend to use habitacion_numero
        // For now, let's just make sure frontend receives 'habitacion' as the number for display
        foreach ($reservas as &$res) {
            $res['habitacion'] = $res['habitacion_numero']; // Alias for frontend compatibility
            if ($res['nombre_habitacion']) {
                $res['habitacion'] .= " (" . $res['nombre_habitacion'] . ")";
            }
        }
        echo json_encode($reservas);
        break;

    case 'POST':
        $input = json_decode(file_get_contents('php://input'), true);
        $db->beginTransaction();
        try {
            // Validate inputs
            if (empty($input['nombre']) || empty($input['apellidos']) || empty($input['entrada']) || empty($input['salida'])) {
                throw new Exception("Faltan datos obligatorios.");
            }

            $stmtUser = $db->prepare("INSERT INTO usuarios (nombre, apellidos, email, password) VALUES (?, ?, ?, ?)");
            $email = strtolower(str_replace(' ', '', $input['nombre'])) . rand(1, 9999) . "@paradise.com";
            $pass = password_hash("1234", PASSWORD_DEFAULT);
            $stmtUser->execute([$input['nombre'], $input['apellidos'], $email, $pass]);
            $user_id = $db->lastInsertId();

            // VALIDACIÓN DE FECHAS
            $res_entrada = $input['entrada'];
            $res_salida = $input['salida'];
            $hoy = date("Y-m-d");

            if ($res_entrada < $hoy) {
                throw new Exception("La fecha de entrada no puede ser anterior a hoy.");
            }
            if ($res_salida <= $res_entrada) {
                throw new Exception("La fecha de salida debe ser posterior a la de entrada.");
            }

            // Using habitacion_id and habitacion_numero
            $habitacion_id = !empty($input['habitacion_id']) ? $input['habitacion_id'] : null;
            $habitacion_numero = !empty($input['habitacion_numero']) ? $input['habitacion_numero'] : 0;

            $stmtRes = $db->prepare("INSERT INTO reservas (usuario_id, fecha_entrada, fecha_salida, habitacion_id, habitacion_numero) VALUES (?, ?, ?, ?, ?)");
            $stmtRes->execute([$user_id, $res_entrada, $res_salida, $habitacion_id, $habitacion_numero]);
            $db->commit();
            echo json_encode(["status" => "success", "mensaje" => "¡Reserva Confirmada!"]);
        } catch (Exception $e) {
            $db->rollBack();
            http_response_code(500);
            echo json_encode(["error" => "Error al reservar: " . $e->getMessage()]);
        }
        break;

    case 'PUT':
        $input = json_decode(file_get_contents('php://input'), true);
        // Assuming 'habitacion' in PUT is the number based on typical edit flow
        $stmt = $db->prepare("UPDATE reservas SET fecha_entrada = ?, fecha_salida = ?, habitacion_numero = ? WHERE id = ?");
        $stmt->execute([$input['entrada'], $input['salida'], $input['habitacion'], $input['id']]);
        echo json_encode(["status" => "success", "mensaje" => "Reserva actualizada correctamente"]);
        break;

    case 'DELETE':
        $input = json_decode(file_get_contents('php://input'), true);
        $stmt = $db->prepare("DELETE FROM reservas WHERE id = ?");
        $stmt->execute([$input['id']]);
        echo json_encode(["status" => "success"]);
        break;
}
exit;
?>
