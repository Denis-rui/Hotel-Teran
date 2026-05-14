// Exponer funciones en window para que sean accesibles desde cualquier lugar
window.actualizarHabitaciones = (e) => {
  // Verificamos si el elemento que disparó el evento es de nuestros filtros
  // o si es un llamado manual sin evento
  const targetId = e?.target?.id || "";
  const targetName = e?.target?.name || "";
  const isManual = !e || (!targetId && !targetName);

  if (
    isManual ||
    targetId === "inputBuscar" ||
    targetName === "id_tipo_habitacion" ||
    targetName === "estado"
  ) {
    const form = document.querySelector(".seccion-filtros");
    const grid = document.querySelector(".grid-habitaciones");

    if (!form || !grid) return;

    const params = new URLSearchParams(new FormData(form)).toString();

    fetch(`Controllers/buscar_habitaciones.php?${params}`, {
      headers: { "X-Requested-With": "XMLHttpRequest" },
    })
      .then((res) => res.text())
      .then((html) => (grid.innerHTML = html))
      .catch(() => (grid.innerHTML = "<p>Error al cargar.</p>"));
  }
};

// Delegamos los eventos al 'document'
document.addEventListener("input", window.actualizarHabitaciones);
document.addEventListener("change", window.actualizarHabitaciones);

// Función global para cambiar el estado
window.cambiarEstado = async (id, nuevoEstado) => {
  if (typeof Confirmar !== "function") {
    console.error(
      "La función Confirmar no está cargada. Asegúrate de que Notificaciones.js esté en index.php",
    );
    return;
  }

  const confirmacion = await Confirmar(
    `¿Desea cambiar el estado de la habitación a "${nuevoEstado}"?`,
  );

  if (!confirmacion) {
    window.actualizarHabitaciones(); // Resetear vista
    return;
  }

  try {
    const formData = new FormData();
    formData.append("accion", "cambiar_estado");
    formData.append("id", id);
    formData.append("estado", nuevoEstado);

    const res = await fetch("Controllers/habitacionesGuardar.php", {
      method: "POST",
      body: formData,
    });

    const resultado = await res.json();

    if (resultado.exito) {
      if (typeof Notificar === "function") {
        Notificar(resultado.mensaje, "exito");
      }
      window.actualizarHabitaciones();
    } else {
      const msg = resultado.mensaje || "Error desconocido";
      if (typeof Notificar === "function") {
        Notificar("Error: " + msg, "error");
      }
      window.actualizarHabitaciones();
    }
  } catch (error) {
    console.error("Error:", error);
    if (typeof Notificar === "function") {
      Notificar("Error de conexión con el servidor.", "error");
    }
  }
};
