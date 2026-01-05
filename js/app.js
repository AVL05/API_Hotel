/**
 * Cambia entre pestañas (Reserva / Admin)
 */
function switchTab(id) {
	const section = document.querySelector("#" + id);
	if (!section) {
		alert("Área privada. Solo personal autorizado.");
		return;
	}
	document.querySelectorAll(".section").forEach((s) => s.classList.remove("active"));
	section.classList.add("active");
	if (id === "admin") loadReservas();
}

/**
 * LOGIN: Autenticación de administrador
 */
async function loginAdmin() {
	const email = prompt("Email admin:");
	const password = prompt("Password admin:");
	if (!email || !password) return;

	try {
		const res = await fetch("index.php?api=true&action=login", {
			method: "POST",
			headers: { "Content-Type": "application/json" },
			body: JSON.stringify({ email, password }),
		});
		const result = await res.json();
		if (res.ok) {
			alert(result.mensaje);
			location.reload();
		} else {
			alert(result.error);
		}
	} catch (err) {
		console.error("Error en login:", err);
	}
}

/**
 * POST: Crear reserva (Público)
 */
async function postReserva() {
	const data = {
		nombre: document.querySelector("#nombre").value,
		apellidos: document.querySelector("#apellidos").value,
		entrada: document.querySelector("#entrada").value,
		salida: document.querySelector("#salida").value,
		habitacion: document.querySelector("#hab").value,
	};

	if (!data.nombre || !data.entrada) return alert("Faltan datos obligatorios");

	const res = await fetch("index.php?api=true", {
		method: "POST",
		headers: { "Content-Type": "application/json" },
		body: JSON.stringify(data),
	});

	const result = await res.json();
	alert(result.mensaje);
	if (res.ok) location.reload();
}

/**
 * GET: Cargar reservas (Solo Admin)
 */
async function loadReservas() {
	try {
		const res = await fetch("index.php?api=true");
		if (!res.ok) return;

		const reservas = await res.json();
		const tbody = document.querySelector("#tablaAdmin tbody");
		if (!tbody) return;

		tbody.innerHTML = "";
		reservas.forEach((r) => {
			tbody.innerHTML += `
                <tr>
                    <td>${r.nombre} ${r.apellidos}</td>
                    <td>${r.fecha_entrada}</td>
                    <td>${r.fecha_salida}</td>
                    <td>${r.habitacion}</td>
                    <td>
                        <button class="btn-action btn-edit" onclick="putReserva(${r.id})">Editar</button>
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
 * DELETE: Borrar reserva (Solo Admin)
 */
async function deleteReserva(id) {
	if (!confirm("¿Desea borrar esta reserva permanentemente?")) return;

	await fetch("index.php?api=true", {
		method: "DELETE",
		headers: { "Content-Type": "application/json" },
		body: JSON.stringify({ id: id }),
	});
	loadReservas();
}

/**
 * PUT: Modificar reserva (Solo Admin)
 */
async function putReserva(id) {
	const ent = prompt("Nueva Entrada (YYYY-MM-DD):");
	const sal = prompt("Nueva Salida (YYYY-MM-DD):");
	const hab = prompt("Nueva Habitación:");
	if (!ent || !sal) return;

	await fetch("index.php?api=true", {
		method: "PUT",
		headers: { "Content-Type": "application/json" },
		body: JSON.stringify({ id, entrada: ent, salida: sal, habitacion: hab }),
	});
	loadReservas();
}
