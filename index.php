<?php
session_start();

// --- CONFIGURACIÓN DE LA API ---
$dbConfig = json_decode(file_get_contents('credenciales.txt'), true);

function conectar()
{
    global $dbConfig;
    try {
        $pdo = new PDO("mysql:host={$dbConfig['host']};dbname={$dbConfig['db']};charset=utf8", $dbConfig['username'], $dbConfig['password']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        http_response_code(500);
        exit(json_encode(["error" => "Error de conexión"]));
    }
}

$es_api = (isset($_GET['api']) || $_SERVER['REQUEST_METHOD'] !== 'GET');

if ($es_api) {
    header("Content-Type: application/json");
    $db = conectar();
    $metodo = $_SERVER['REQUEST_METHOD'];
    $accion = $_GET['action'] ?? '';

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
            exit;
        } else {
            http_response_code(401);
            echo json_encode(["error" => "Credenciales incorrectas"]);
            exit;
        }
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
            $sql = "SELECT r.id, u.nombre, u.apellidos, r.fecha_entrada, r.fecha_salida, r.habitacion FROM reservas r INNER JOIN usuarios u ON r.usuario_id = u.id ORDER BY r.id DESC";
            $stmt = $db->query($sql);
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;

        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            $db->beginTransaction();
            try {
                $stmtUser = $db->prepare("INSERT INTO usuarios (nombre, apellidos, email, password) VALUES (?, ?, ?, ?)");
                $email = strtolower($input['nombre']) . rand(1, 999) . "@paradise.com";
                $pass = password_hash("1234", PASSWORD_DEFAULT);
                $stmtUser->execute([$input['nombre'], $input['apellidos'], $email, $pass]);
                $user_id = $db->lastInsertId();

                $stmtRes = $db->prepare("INSERT INTO reservas (usuario_id, fecha_entrada, fecha_salida, habitacion) VALUES (?, ?, ?, ?)");
                $stmtRes->execute([$user_id, $input['entrada'], $input['salida'], $input['habitacion']]);
                $db->commit();
                echo json_encode(["status" => "success", "mensaje" => "¡Reserva Confirmada!"]);
            } catch (Exception $e) {
                $db->rollBack();
                http_response_code(500);
                echo json_encode(["error" => "Error al reservar"]);
            }
            break;

        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            $stmt = $db->prepare("UPDATE reservas SET fecha_entrada = ?, fecha_salida = ?, habitacion = ? WHERE id = ?");
            $stmt->execute([$input['entrada'], $input['salida'], $input['habitacion'], $input['id']]);
            echo json_encode(["status" => "success"]);
            break;

        case 'DELETE':
            $input = json_decode(file_get_contents('php://input'), true);
            $stmt = $db->prepare("DELETE FROM reservas WHERE id = ?");
            $stmt->execute([$input['id']]);
            echo json_encode(["status" => "success"]);
            break;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Hotel Paradise - WebService</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
    <header class="header-main">
        <h1 class="title-hotel">PARADISE HOTEL</h1>
        <p class="subtitle-hotel">LUJO • EXCLUSIVIDAD • BIENESTAR</p>
        <?php if (isset($_SESSION['admin_id'])): ?>
            <div class="user-badge">Personal Autorizado: <?php echo $_SESSION['admin_nombre']; ?></div>
        <?php endif; ?>
    </header>

    <nav class="nav-bar">
        <button class="nav-btn" onclick="switchTab('reserva')">RESERVAR</button>
        <?php if (isset($_SESSION['admin_id'])): ?>
            <button class="nav-btn" onclick="switchTab('admin')">ADMINISTRACIÓN</button>
            <button class="nav-btn" onclick="location.href='index.php?api=true&action=logout'">SALIR</button>
        <?php else: ?>
            <button class="nav-btn" onclick="loginAdmin()">LOGIN ADMIN</button>
        <?php endif; ?>
    </nav>

    <main class="container-main">
        <div id="reserva" class="section active">
            <h2>Realizar Reserva</h2>
            <div class="form-row">
                <input type="text" id="nombre" class="input-field" placeholder="Nombre">
                <input type="text" id="apellidos" class="input-field" placeholder="Apellidos">
            </div>
            <div class="form-row">
                <label>Entrada: <input type="date" id="entrada" class="input-field"></label>
                <label>Salida: <input type="date" id="salida" class="input-field"></label>
            </div>
            <input type="number" id="hab" class="input-field" placeholder="Nº Habitación" style="margin-bottom:20px;">
            <button class="btn-primary" onclick="postReserva()">CONFIRMAR AHORA</button>
        </div>

        <?php if (isset($_SESSION['admin_id'])): ?>
            <div id="admin" class="section">
                <h2>Gestión de Reservas</h2>
                <table id="tablaAdmin" class="table-admin">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Entrada</th>
                            <th>Salida</th>
                            <th>Hab.</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>
    <script src="./js/app.js"></script>
</body>

</html>