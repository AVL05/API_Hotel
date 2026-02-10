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
    event.target.classList.remove("open");
  }
};

/**
 * LOGIN
 */
async function submitLogin() {
  const email = document.getElementById("loginEmail").value;
  const password = document.getElementById("loginPass").value;

  if (!email || !password) return alert("Por favor complete todos los campos");

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
      alert(result.error);
    }
  } catch (err) {
    console.error("Error en login:", err);
    alert("Error de conexión");
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
    habitacion: document.querySelector("#hab").value,
  };

  if (!data.nombre || !data.entrada || !data.salida)
    return alert("Faltan datos obligatorios");

  // Validación Frontend
  const hoy = new Date().toISOString().split("T")[0];
  if (data.entrada < hoy)
    return alert("La fecha de entrada no puede ser anterior a hoy.");
  if (data.salida <= data.entrada)
    return alert("La fecha de salida debe ser posterior a la de entrada.");

  try {
    const res = await fetch("api.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });

    const result = await res.json();
    alert(result.mensaje || result.error);
    if (res.ok) {
      // Redirigir a index o limpiar formulario
      window.location.href = "index.php";
    }
  } catch (e) {
    alert("Error al conectar con el servidor: " + e);
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
    loadReservas();
  } catch (e) {
    alert("Error al eliminar");
  }
}

/**
 * EDITAR (PUT)
 */
function openEditModal(reserva) {
  document.getElementById("editId").value = reserva.id;
  document.getElementById("editEntrada").value = reserva.fecha_entrada;
  document.getElementById("editSalida").value = reserva.fecha_salida;
  document.getElementById("editHab").value = reserva.habitacion;

  document.getElementById("modalEdit").classList.add("open");
}

async function submitEdit() {
  const id = document.getElementById("editId").value;
  const ent = document.getElementById("editEntrada").value;
  const sal = document.getElementById("editSalida").value;
  const hab = document.getElementById("editHab").value;

  if (!ent || !sal) return alert("Fechas obligatorias");

  // Validaciones FE
  if (sal <= ent) return alert("La fecha de salida debe ser posterior");

  try {
    const res = await fetch("api.php", {
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ id, entrada: ent, salida: sal, habitacion: hab }),
    });

    const result = await res.json();
    if (res.ok) {
      alert(result.mensaje);
      closeModal("modalEdit");
      loadReservas();
    } else {
      alert(result.error);
    }
  } catch (e) {
    alert("Error al actualizar");
  }
}
