<?php require_once 'includes/header.php'; ?>

<main class="page-container">
    <section class="hero-section">
        <div class="hero-content">
            <h2>Bienvenido al Paraíso</h2>
            <p>Descubre el verdadero significado del lujo y la comodidad.</p>
            <a href="reservar.php" class="btn-hero">Reserva tu Estancia</a>
        </div>
    </section>

    <section class="features-section">
        <div class="feature-card">
            <i class="fas fa-spa"></i>
            <h3>Spa & Wellness</h3>
            <p>Relájate en nuestro spa de clase mundial con tratamientos exclusivos.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-utensils"></i>
            <h3>Alta Gastronomía</h3>
            <p>Disfruta de la mejor cocina internacional en nuestros 3 restaurantes.</p>
        </div>
        <div class="feature-card">
            <i class="fas fa-swimming-pool"></i>
            <h3>Piscinas Infinitas</h3>
            <p>Sumérgete en nuestras piscinas con vistas al océano.</p>
        </div>
    </section>

    <section class="room-preview">
        <h2>Nuestras Habitaciones Destacadas</h2>
        <div class="room-grid">
            <div class="room-card">
                <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Suite">
                <div class="room-info">
                    <h3>Suite Presidencial</h3>
                    <p>La máxima expresión del lujo con vistas panorámicas.</p>
                    <a href="habitaciones.php" class="btn-secondary">Ver Más</a>
                </div>
            </div>
            <div class="room-card">
                <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Deluxe">
                <div class="room-info">
                    <h3>Habitación Deluxe</h3>
                    <p>Confort y elegancia para una estancia perfecta.</p>
                    <a href="habitaciones.php" class="btn-secondary">Ver Más</a>
                </div>
            </div>
            <div class="room-card">
                <img src="https://images.unsplash.com/photo-1566665797739-1674de7a421a?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Standard">
                <div class="room-info">
                    <h3>Junior Suite</h3>
                    <p>Espacio y diseño moderno para viajeros exigentes.</p>
                    <a href="habitaciones.php" class="btn-secondary">Ver Más</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>
