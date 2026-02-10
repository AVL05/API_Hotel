<?php require_once 'includes/header.php'; ?>

<main class="page-container">
    <div class="page-header">
        <h2>Contáctanos</h2>
        <p>Estamos aquí para ayudarte a planificar tu estancia perfecta.</p>
    </div>

    <div class="contact-wrapper">
        <div class="contact-info-panel">
            <h3>Información de Contacto</h3>
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <p>Calle Paraíso 123<br>29600, Costa del Sol, Málaga<br>España</p>
            </div>
            <div class="contact-item">
                <i class="fas fa-phone"></i>
                <p>+34 900 123 456<br>+34 952 11 22 33</p>
            </div>
            <div class="contact-item">
                <i class="fas fa-envelope"></i>
                <p>reservas@paradisehotel.com<br>info@paradisehotel.com</p>
            </div>
            <div class="social-contact">
                <a href="#"><i class="fab fa-instagram"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-facebook"></i></a>
            </div>
        </div>

        <div class="contact-form-panel">
            <h3>Envíanos un Mensaje</h3>
            <form id="contactForm" onsubmit="event.preventDefault(); alert('Gracias por su mensaje. Nos pondremos en contacto pronto.');">
                <div class="input-group">
                    <label class="input-label">Nombre Completo</label>
                    <input type="text" class="input-field" required>
                </div>
                <div class="input-group">
                    <label class="input-label">Email</label>
                    <input type="email" class="input-field" required>
                </div>
                <div class="input-group">
                    <label class="input-label">Asunto</label>
                    <input type="text" class="input-field">
                </div>
                <div class="input-group">
                    <label class="input-label">Mensaje</label>
                    <textarea class="input-field" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn-primary">Enviar Mensaje</button>
            </form>
        </div>
    </div>
</main>

<style>
.contact-wrapper {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 40px;
}
.contact-info-panel {
    background: var(--dark);
    color: var(--white);
    padding: 40px;
    border-radius: 8px;
}
.contact-info-panel h3 {
    color: var(--gold);
    margin-bottom: 30px;
}
.contact-item {
    display: flex;
    align-items: start;
    margin-bottom: 25px;
}
.contact-item i {
    color: var(--gold);
    margin-right: 15px;
    margin-top: 5px;
}
.social-contact {
    margin-top: 40px;
}
.social-contact a {
    color: var(--white);
    margin-right: 20px;
    font-size: 1.2rem;
    transition: color 0.3s;
}
.social-contact a:hover {
    color: var(--gold);
}
@media (max-width: 768px) {
    .contact-wrapper {
        grid-template-columns: 1fr;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>
