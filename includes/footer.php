<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
    <footer class="footer-main">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Hotel Paradise</h3>
                <p>Donde el lujo se encuentra con la naturaleza. Vive una experiencia inolvidable en nuestras exclusivas instalaciones.</p>
            </div>
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <ul>
                    <li><a href="index.php">Inicio</a></li>
                    <li><a href="habitaciones.php">Habitaciones</a></li>
                    <li><a href="reservar.php">Reservar</a></li>
                    <li><a href="contacto.php">Contacto</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contacto</h3>
                <p><i class="fas fa-map-marker-alt"></i> Calle Paraíso 123, Costa del Sol</p>
                <p><i class="fas fa-phone"></i> +34 900 123 456</p>
                <p><i class="fas fa-envelope"></i> info@paradisehotel.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date("Y"); ?> Hotel Paradise. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- ALERT CUSTOM MODAL -->
    <div id="customAlert" class="modal-overlay">
        <div class="modal alert-modal">
            <div class="alert-icon" id="alertIcon"></div>
            <h3 id="alertTitle" class="alert-title"></h3>
            <p id="alertMessage" class="alert-message"></p>
            <button class="btn-primary" onclick="closeCustomAlert()">Entendido</button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="./assets/js/app.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
