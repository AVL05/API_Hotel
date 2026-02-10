<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Paradise - Luxury Experience</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./assets/css/styles.css">
</head>

<body>
    <header class="header-main">
        <div class="top-bar">
            <div class="contact-info">
                <span><i class="fas fa-phone"></i> +34 900 123 456</span>
                <span><i class="fas fa-envelope"></i> reservas@paradise.com</span>
            </div>
            <div class="social-icons">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
            </div>
        </div>
        <div class="header-content">
            <h1 class="title-hotel">PARADISE HOTEL</h1>
            <p class="subtitle-hotel">Lujo • Exclusividad • Bienestar</p>
        </div>
    </header>

    <nav class="nav-bar">
        <div class="nav-links">
            <a href="index.php" class="nav-btn <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">Inicio</a>
            <a href="habitaciones.php" class="nav-btn <?php echo ($current_page == 'habitaciones.php') ? 'active' : ''; ?>">Habitaciones</a>
            <a href="reservar.php" class="nav-btn <?php echo ($current_page == 'reservar.php') ? 'active' : ''; ?>">Reservar</a>
            <a href="contacto.php" class="nav-btn <?php echo ($current_page == 'contacto.php') ? 'active' : ''; ?>">Contacto</a>
        </div>
        <div class="nav-admin">
            <?php if (isset($_SESSION['admin_id'])): ?>
                <div class="user-menu">
                    <span class="user-greeting"><i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($_SESSION['admin_nombre'] ?? 'Admin'); ?></span>
                    <a href="admin.php" class="nav-btn <?php echo ($current_page == 'admin.php') ? 'active' : ''; ?>" title="Panel de Control"><i class="fas fa-tachometer-alt"></i> Panel</a>
                    <a href="api.php?action=logout" class="nav-btn btn-logout" title="Cerrar Sesión"><i class="fas fa-sign-out-alt"></i> Salir</a>
                </div>
            <?php else: ?>
                <button class="nav-btn btn-staff" onclick="openLoginModal()"><i class="fas fa-lock"></i> Acceso Staff</button>
            <?php endif; ?>
        </div>
    </nav>

    <!-- MODAL LOGIN GLOBAL -->
    <div id="modalLogin" class="modal-overlay">
        <div class="modal">
            <div class="modal-header">
                <h3 class="modal-title">Acceso Administrativo</h3>
                <button class="modal-close" onclick="closeModal('modalLogin')">&times;</button>
            </div>
            <div class="modal-body">
                <div class="input-group">
                    <label class="input-label">Email</label>
                    <input type="email" id="loginEmail" class="input-field" placeholder="admin@hotel.com">
                </div>
                <div class="input-group">
                    <label class="input-label">Contraseña</label>
                    <input type="password" id="loginPass" class="input-field" placeholder="******">
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeModal('modalLogin')">Cancelar</button>
                <button class="btn-primary" style="width: auto; margin:0;" onclick="submitLogin()">Entrar</button>
            </div>
        </div>
    </div>
