<?php
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
        exit(json_encode(["error" => $e->getMessage()]));
    }
}

// DETECTAR SI ES UNA LLAMADA API O WEB
$es_api = (isset($_GET['api']) || $_SERVER['REQUEST_METHOD'] !== 'GET');

if ($es_api) {
    header("Content-Type: application/json");
    $db = conectar();
    $metodo = $_SERVER['REQUEST_METHOD'];

    switch ($metodo) {
        case 'GET': // Consultar todas las reservas (Formato JSON)
            $stmt = $db->query("SELECT * FROM reservas ORDER BY id DESC");
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            break;

        case 'POST': // Crear reserva
            $input = json_decode(file_get_contents('php://input'), true);
            $sql = "INSERT INTO reservas (nombre, apellidos, fecha_entrada, fecha_salida, habitacion) VALUES (?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$input['nombre'], $input['apellidos'], $input['entrada'], $input['salida'], $input['habitacion']]);
            echo json_encode(["status" => "success", "mensaje" => "Reserva confirmada"]);
            break;

        case 'DELETE': // Borrar reserva
            $input = json_decode(file_get_contents('php://input'), true);
            $stmt = $db->prepare("DELETE FROM reservas WHERE id = ?");
            $stmt->execute([$input['id']]);
            echo json_encode(["status" => "deleted"]);
            break;
    }
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resorts & Spa - Hotel Paradise</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #c5a059;
            --dark: #121212;
            --bg: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg);
            margin: 0;
            color: #333;
        }

        header {
            background: var(--dark);
            color: white;
            padding: 60px 20px;
            text-align: center;
            border-bottom: 5px solid var(--gold);
        }

        h1 {
            font-family: 'Playfair Display', serif;
            font-size: 3rem;
            margin: 0;
            letter-spacing: 4px;
        }

        .nav {
            background: #fff;
            text-align: center;
            padding: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav button {
            background: none;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            cursor: pointer;
            color: var(--dark);
            transition: 0.3s;
        }

        .nav button:hover {
            color: var(--gold);
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        }

        .section {
            display: none;
        }

        .active {
            display: block;
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        /* Formularios */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        input {
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
        }

        input:focus {
            border-color: var(--gold);
        }

        button.main-btn {
            background: var(--dark);
            color: var(--gold);
            border: 2px solid var(--gold);
            padding: 15px 30px;
            font-weight: bold;
            width: 100%;
            cursor: pointer;
            transition: 0.3s;
        }

        button.main-btn:hover {
            background: var(--gold);
            color: white;
        }

        /* Tabla Admin */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 0.9rem;
        }

        th {
            background: var(--dark);
            color: var(--gold);
            padding: 12px;
            text-align: left;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .cancel-btn {
            background: #ff4757;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>

    <header>
        <h1>PARADISE HOTEL</h1>
        <p>LUJO • EXCLUSIVIDAD • BIENESTAR</p>
    </header>

    <div class="nav">
        <button onclick="switchTab('reserva')">RESERVAR HABITACIÓN</button>
        <button onclick="switchTab('admin')">ADMINISTRACIÓN</button>
    </div>

    <div class="container">
        <div id="reserva" class="section active">
            <h2 style="text-align:center; color: var(--gold);">Solicitud de Estancia</h2>
            <div class="form-row">
                <input type="text" id="nombre" placeholder="Su Nombre">
                <input type="text" id="apellidos" placeholder="Sus Apellidos">
            </div>
            <div class="form-row">
                <label>Fecha de Entrada: <input type="date" id="entrada"></label>
                <label>Fecha de Salida: <input type="date" id="salida"></label>
            </div>
            <input type="number" id="hab" placeholder="Número de Habitación deseada" style="width: 100%; margin-bottom:20px;">
            <button class="main-btn" onclick="postReserva()">CONFIRMAR RESERVA AHORA</button>
        </div>

        <div id="admin" class="section">
            <h2 style="text-align:center; color: var(--gold);">Gestión de Reservas</h2>
            <table id="tablaAdmin">
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
    </div>

    <script>
        function switchTab(id) {
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            document.getElementById(id).classList.add('active');
            if (id === 'admin') loadReservas();
        }

        // LLAMADA API: POST
        async function postReserva() {
            const data = {
                nombre: document.getElementById('nombre').value,
                apellidos: document.getElementById('apellidos').value,
                entrada: document.getElementById('entrada').value,
                salida: document.getElementById('salida').value,
                habitacion: document.getElementById('hab').value
            };

            const res = await fetch('index.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await res.json();
            alert(result.mensaje);
            location.reload();
        }

        // LLAMADA API: GET
        async function loadReservas() {
            const res = await fetch('index.php?api=true');
            const reservas = await res.json();
            const tbody = document.querySelector('#tablaAdmin tbody');
            tbody.innerHTML = '';

            reservas.forEach(r => {
                tbody.innerHTML += `
                <tr>
                    <td>${r.nombre} ${r.apellidos}</td>
                    <td>${r.fecha_entrada}</td>
                    <td>${r.fecha_salida}</td>
                    <td>${r.habitacion}</td>
                    <td><button class="cancel-btn" onclick="deleteReserva(${r.id})">Eliminar</button></td>
                </tr>
            `;
            });
        }

        // LLAMADA API: DELETE
        async function deleteReserva(id) {
            if (!confirm("¿Desea cancelar esta reserva de forma permanente?")) return;
            await fetch('index.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: id
                })
            });
            loadReservas();
        }
    </script>

</body>

</html>