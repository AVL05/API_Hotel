<?php require_once 'includes/header.php'; ?>

<main class="page-container">
    <div class="page-header">
        <h2>Nuestras Habitaciones</h2>
        <p>Elige el espacio perfecto para tu descanso</p>
    </div>

    <div class="rooms-container">
        <!-- Habitación 1 -->
        <div class="room-detailed">
            <div class="room-image">
                <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Suite Presidencial">
            </div>
            <div class="room-description">
                <h3>Suite Presidencial</h3>
                <p>Nuestra suite más exclusiva cuenta con 120m², terraza privada con jacuzzi, salón independiente y servicio de mayordomo 24h. Ideal para quienes buscan la excelencia absoluta.</p>
                <ul class="room-amenities">
                    <li><i class="fas fa-wifi"></i> Wifi Alta Velocidad</li>
                    <li><i class="fas fa-tv"></i> Smart TV 65"</li>
                    <li><i class="fas fa-hot-tub"></i> Jacuzzi Privado</li>
                    <li><i class="fas fa-snowflake"></i> Aire Acondicionado</li>
                </ul>
                <div class="room-price">Desde <strong>350€</strong> / noche</div>
                <a href="reservar.php" class="btn-primary">Reservar Ahora</a>
            </div>
        </div>

        <!-- Habitación 2 -->
        <div class="room-detailed reverse">
            <div class="room-image">
                <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Deluxe Room">
            </div>
            <div class="room-description">
                <h3>Habitación Deluxe</h3>
                <p>Elegancia y confort en 45m². Disfruta de vistas al jardín tropical, cama King Size y baño de mármol con ducha de lluvia. Una experiencia de relajación total.</p>
                <ul class="room-amenities">
                    <li><i class="fas fa-wifi"></i> Wifi Gratuito</li>
                    <li><i class="fas fa-coffee"></i> Cafetera Nespresso</li>
                    <li><i class="fas fa-glass-martini-alt"></i> Minibar</li>
                    <li><i class="fas fa-concierge-bell"></i> Room Service</li>
                </ul>
                <div class="room-price">Desde <strong>180€</strong> / noche</div>
                <a href="reservar.php" class="btn-primary">Reservar Ahora</a>
            </div>
        </div>

        <!-- Habitación 3 -->
        <div class="room-detailed">
            <div class="room-image">
                <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80" alt="Junior Suite">
            </div>
            <div class="room-description">
                <h3>Junior Suite</h3>
                <p>Perfecta para familias o estancias largas. 60m² con zona de estar integrada, balcón privado y todas las comodidades tecnológicas modernas.</p>
                <ul class="room-amenities">
                    <li><i class="fas fa-wifi"></i> Wifi Premium</li>
                    <li><i class="fas fa-couch"></i> Zona de Estar</li>
                    <li><i class="fas fa-bath"></i> Bañera</li>
                    <li><i class="fas fa-music"></i> Sistema de Sonido</li>
                </ul>
                <div class="room-price">Desde <strong>240€</strong> / noche</div>
                <a href="reservar.php" class="btn-primary">Reservar Ahora</a>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
