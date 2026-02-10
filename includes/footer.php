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

    <!-- Scripts -->
    <script src="./assets/js/app.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
