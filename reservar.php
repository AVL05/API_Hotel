<?php require_once 'includes/header.php'; ?>

<main class="page-container">
    <div class="page-header">
        <h2>Reserva tu Próxima Experiencia</h2>
        <p>Completa el formulario y asegura tu lugar en el paraíso.</p>
    </div>

    <div class="booking-section">
        <div class="booking-form-container">
            <h3>Detalles de la Reserva</h3>
            <div id="reserva-form" class="form-wrapper">
                <div class="form-row">
                    <div class="input-group">
                        <label class="input-label">Nombre</label>
                        <input type="text" id="nombre" class="input-field" placeholder="Tu nombre">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Apellidos</label>
                        <input type="text" id="apellidos" class="input-field" placeholder="Tus apellidos">
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-group">
                        <label class="input-label">Fecha de Entrada</label>
                        <input type="date" id="entrada" class="input-field">
                    </div>
                    <div class="input-group">
                        <label class="input-label">Fecha de Salida</label>
                        <input type="date" id="salida" class="input-field">
                    </div>
                </div>
                <!-- Selección de Tipo de Habitación (Mockup Visual) -->
                <div class="input-group">
                    <label class="input-label">Tipo de Habitación</label>
                    <select class="input-field" onchange="suggestRoomNumber(this)">
                        <option value="">Selecciona una opción...</option>
                        <option value="1">Suite Presidencial</option>
                        <option value="2">Habitación Deluxe</option>
                        <option value="3">Junior Suite</option>
                    </select>
                </div>
                
                <div class="input-group" style="margin-bottom: 30px;">
                    <label class="input-label">Número de Habitación (Asignación Automática / Preferencia)</label>
                    <input type="number" id="hab" class="input-field" placeholder="Ej: 105">
                </div>

                <div class="price-summary" id="priceSummary" style="display:none; margin-bottom: 20px; padding: 15px; background: #fafafa; border-left: 4px solid var(--gold);">
                    <p><strong>Estancia estimada:</strong> <span id="daysCount">0</span> noches</p>
                    <p><strong>Total aproximado:</strong> <span id="totalPrice">0</span>€</p>
                </div>

                <button class="btn-primary" onclick="postReserva()">Confirmar Reserva</button>
            </div>
            <div class="secure-badge">
                <i class="fas fa-shield-alt"></i> Reserva Segura garantizada. Sin cargos ocultos.
            </div>
        </div>
        
        <div class="booking-sidebar">
            <div class="info-card">
                <h4>¿Por qué reservar con nosotros?</h4>
                <ul>
                    <li><i class="fas fa-check"></i> Mejor precio garantizado</li>
                    <li><i class="fas fa-check"></i> Cancelación flexible hasta 48h</li>
                    <li><i class="fas fa-check"></i> Bebida de bienvenida</li>
                    <li><i class="fas fa-check"></i> Acceso gratuito al Spa</li>
                </ul>
            </div>
        </div>
    </div>
</main>

<script>
    // Pequeño script para calcular precio estimado en tiempo real (Frontend only)
    const entradaIn = document.getElementById('entrada');
    const salidaIn = document.getElementById('salida');
    
    function updatePrice() {
        if(entradaIn.value && salidaIn.value) {
            const start = new Date(entradaIn.value);
            const end = new Date(salidaIn.value);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
            
            if(diffDays > 0) {
                document.getElementById('priceSummary').style.display = 'block';
                document.getElementById('daysCount').innerText = diffDays;
                // Precio base promedio 200
                document.getElementById('totalPrice').innerText = diffDays * 200;
            }
        }
    }

    entradaIn.addEventListener('change', updatePrice);
    salidaIn.addEventListener('change', updatePrice);

    function suggestRoomNumber(select) {
        const input = document.getElementById('hab');
        // Simple lógica para sugerir número
        if(select.value == '1') input.value = 501; // Suites planta 5
        if(select.value == '2') input.value = 205; // Deluxe planta 2
        if(select.value == '3') input.value = 102; // Junior planta 1
    }
</script>

<?php require_once 'includes/footer.php'; ?>
