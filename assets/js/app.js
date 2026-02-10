/**
 * UTILIDADES MODAL
 */
function openLoginModal() {
  const modal = document.getElementById("modalLogin");
  if (modal) modal.classList.add("open");
}

function closeModal(id) {
  const modal = document.getElementById(id);
  if (modal) modal.classList.remove("open");
}

// Cerrar modal al hacer click fuera
window.onclick = function (event) {
  if (event.target.classList.contains("modal-overlay")) {
    if (event.target.id === "customAlert") return; // No cerrar alert al click fuera por seguridad
    event.target.classList.remove("open");
  }
};

/**
 * SISTEMA DE ALERTAS PERSONALIZADAS
 */
let alertCallback = null;

function showCustomAlert(title, message, type = "info", callback = null) {
  const modal = document.getElementById("customAlert");
  const iconContainer = document.getElementById("alertIcon");
  const titleEl = document.getElementById("alertTitle");
  const msgEl = document.getElementById("alertMessage");

  // Configurar contenido
  titleEl.innerText = title;
  msgEl.innerText = message;
  alertCallback = callback;

  // Configurar icono y estilo
  iconContainer.className = "alert-icon"; // Reset
  if (type === "success") {
    iconContainer.innerHTML = '<i class="fas fa-check"></i>';
    iconContainer.classList.add("alert-success");
  } else if (type === "error") {
    iconContainer.innerHTML = '<i class="fas fa-times"></i>';
    iconContainer.classList.add("alert-error");
  } else {
    iconContainer.innerHTML = '<i class="fas fa-info"></i>';
    iconContainer.classList.add("alert-info");
  }

  modal.classList.add("open");
}

function closeCustomAlert() {
  document.getElementById("customAlert").classList.remove("open");
  if (alertCallback) {
    alertCallback();
    alertCallback = null;
  }
}

/**
 * LOGIN
 */
async function submitLogin() {
  const email = document.getElementById("loginEmail").value;
  const password = document.getElementById("loginPass").value;

  if (!email || !password)
    return showCustomAlert(
      "Error",
      "Por favor complete todos los campos",
      "error",
    );

  try {
    const res = await fetch("api.php?action=login", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ email, password }),
    });
    const result = await res.json();
    if (res.ok) {
      // Redirigir a admin.php si el login es exitoso
      window.location.href = "admin.php";
    } else {
      showCustomAlert("Acceso Denegado", result.error, "error");
    }
  } catch (err) {
    console.error("Error en login:", err);
    showCustomAlert(
      "Error de Conexión",
      "No se pudo conectar con el servidor",
      "error",
    );
  }
}

/**
 * INICIALIZACIÓN
 */
document.addEventListener("DOMContentLoaded", () => {
  initDateValidation();
});

function initDateValidation() {
  // Para el formulario de reserva principal
  const entrada = document.querySelector("#entrada");
  const salida = document.querySelector("#salida");

  if (entrada && salida) {
    const hoy = new Date().toISOString().split("T")[0];
    entrada.setAttribute("min", hoy);

    entrada.addEventListener("change", () => {
      if (entrada.value) {
        // La salida debe ser al menos 1 día después
        const fechaEnt = new Date(entrada.value);
        fechaEnt.setDate(fechaEnt.getDate() + 1);
        const minSalida = fechaEnt.toISOString().split("T")[0];

        salida.setAttribute("min", minSalida);

        // Si la fecha actual en salida es menor, la limpiamos
        if (salida.value && salida.value < minSalida) {
          salida.value = minSalida;
        }
      }
    });
  }

  // Para el modal de edición
  const editEntrada = document.querySelector("#editEntrada");
  const editSalida = document.querySelector("#editSalida");
  if (editEntrada && editSalida) {
    editEntrada.addEventListener("change", () => {
      if (editEntrada.value) {
        const fechaEnt = new Date(editEntrada.value);
        fechaEnt.setDate(fechaEnt.getDate() + 1);
        editSalida.setAttribute("min", fechaEnt.toISOString().split("T")[0]);
      }
    });
  }
}

/**
 * CREAR RESERVA (POST)
 */
async function postReserva() {
  const data = {
    nombre: document.querySelector("#nombre").value,
    apellidos: document.querySelector("#apellidos").value,
    entrada: document.querySelector("#entrada").value,
    salida: document.querySelector("#salida").value,
    habitacion_numero: document.querySelector("#hab").value,
    habitacion_id: document.querySelector("#tipo_habitacion").value || null,
  };

  if (!data.nombre || !data.entrada || !data.salida)
    return showCustomAlert(
      "Campos Incompletos",
      "Por favor rellena todos los datos obligatorios para continuar.",
      "error",
    );

  // Validación Frontend
  const hoy = new Date().toISOString().split("T")[0];
  if (data.entrada < hoy)
    return showCustomAlert(
      "Fecha Inválida",
      "La fecha de entrada no puede ser anterior a hoy.",
      "error",
    );
  if (data.salida <= data.entrada)
    return showCustomAlert(
      "Fecha Inválida",
      "La fecha de salida debe ser posterior a la de entrada.",
      "error",
    );

  try {
    const res = await fetch("api.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });

    const result = await res.json();

    if (res.ok) {
      showCustomAlert(
        "¡Reserva Confirmada!",
        "Tu estancia ha sido reservada con éxito. Te esperamos en el paraíso.",
        "success",
        () => {
          window.location.href = "index.php";
        },
      );
    } else {
      showCustomAlert(
        "Error en la Reserva",
        result.error || "Ocurrió un problema inesperado.",
        "error",
      );
    }
  } catch (e) {
    showCustomAlert(
      "Error Crítico",
      "No se pudo conectar con el servidor: " + e,
      "error",
    );
  }
}

/**
 * CARGAR RESERVAS (GET)
 */
async function loadReservas() {
  try {
    const res = await fetch("api.php");
    if (res.status === 401) {
      window.location.href = "index.php"; // No autorizado
      return;
    }
    if (!res.ok) return;

    const reservas = await res.json();
    const tbody = document.querySelector("#tablaAdmin tbody");
    if (!tbody) return;

    tbody.innerHTML = "";

    if (reservas.length === 0) {
      tbody.innerHTML =
        "<tr><td colspan='6' style='text-align:center'>No hay reservas registradas.</td></tr>";
      return;
    }

    reservas.forEach((r) => {
      tbody.innerHTML += `
                <tr>
                    <td>${r.id}</td>
                    <td>
                        <strong>${r.nombre} ${r.apellidos}</strong>
                    </td>
                    <td>${r.fecha_entrada}</td>
                    <td>${r.fecha_salida}</td>
                    <td>${r.habitacion}</td>
                    <td>
                        <button class="btn-action btn-edit" onclick='openEditModal(${JSON.stringify(r)})'>Editar</button>
                        <button class="btn-action btn-delete" onclick="deleteReserva(${r.id})">Borrar</button>
                    </td>
                </tr>
            `;
    });
  } catch (err) {
    console.error("Error cargando reservas:", err);
  }
}

/**
 * BORRAR (DELETE)
 */
async function deleteReserva(id) {
  if (
    !confirm(
      "¿Confirma que desea eliminar esta reserva? Esta acción no se puede deshacer.",
    )
  )
    return;

  try {
    await fetch("api.php", {
      method: "DELETE",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id: id }),
    });
    // No alert needed for simple delete refresh, standard UX
    loadReservas();
  } catch (e) {
    showCustomAlert("Error", "Error al eliminar la reserva", "error");
  }
}

/**
 * EDITAR (PUT)
 */
function openEditModal(reserva) {
  document.getElementById("editId").value = reserva.id;
  document.getElementById("editEntrada").value = reserva.fecha_entrada;
  document.getElementById("editSalida").value = reserva.fecha_salida;
  document.getElementById("editHab").value =
    reserva.habitacion_numero || reserva.habitacion; // Fallback

  document.getElementById("modalEdit").classList.add("open");
}

async function submitEdit() {
  const id = document.getElementById("editId").value;
  const ent = document.getElementById("editEntrada").value;
  const sal = document.getElementById("editSalida").value;
  const hab = document.getElementById("editHab").value;

  if (!ent || !sal)
    return showCustomAlert(
      "Datos Faltantes",
      "Las fechas son obligatorias",
      "error",
    );

  // Validaciones FE
  if (sal <= ent)
    return showCustomAlert(
      "Error Fechas",
      "La fecha de salida debe ser posterior",
      "error",
    );

  try {
    const res = await fetch("api.php", {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id, entrada: ent, salida: sal, habitacion: hab }),
    });

    const result = await res.json();
    if (res.ok) {
      showCustomAlert("Actualizado", result.mensaje, "success", () => {
        closeModal("modalEdit");
        loadReservas();
      });
    } else {
      showCustomAlert("Error", result.error, "error");
    }
  } catch (e) {
    showCustomAlert("Error", "Error al conectar con el servidor", "error");
  }
}
