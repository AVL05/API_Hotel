<?php 
require_once 'includes/header.php'; 

if (!isset($_SESSION['admin_id'])) {
    echo "<script>window.location.href='index.php';</script>";
    exit;
}
?>

<main class="page-container">
    <div class="page-header">
        <h2>Panel de Administración</h2>
        <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['admin_nombre']); ?></p>
    </div>

    <div class="admin-dashboard">
        <div class="admin-actions-bar">
            <button class="btn-primary" onclick="loadReservas()"><i class="fas fa-sync-alt"></i> Actualizar Tabla</button>
            <!-- Aquí podrían ir filtros o búsqueda -->
        </div>

        <div class="table-container shadow-box">
            <table id="tablaAdmin" class="table-admin">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Habitación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Se carga vía AJAX desde api.php -->
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- MODAL EDITAR (Reutilizado) -->
<div id="modalEdit" class="modal-overlay">
    <div class="modal">
        <div class="modal-header">
            <h3 class="modal-title">Editar Reserva</h3>
            <button class="modal-close" onclick="closeModal('modalEdit')">&times;</button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="editId">
            <div class="input-group">
                <label class="input-label">Nueva Entrada</label>
                <input type="date" id="editEntrada" class="input-field">
            </div>
            <div class="input-group">
                <label class="input-label">Nueva Salida</label>
                <input type="date" id="editSalida" class="input-field">
            </div>
            <div class="input-group">
                <label class="input-label">Nueva Habitación</label>
                <input type="number" id="editHab" class="input-field">
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-cancel" onclick="closeModal('modalEdit')">Cancelar</button>
            <button class="btn-primary" style="width: auto; margin:0;" onclick="submitEdit()">Guardar Cambios</button>
        </div>
    </div>
</div>

<script>
    // Cargar reservas automáticamnete al entrar
    document.addEventListener('DOMContentLoaded', loadReservas);
</script>

<?php require_once 'includes/footer.php'; ?>
