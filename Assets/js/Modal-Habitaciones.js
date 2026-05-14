document.addEventListener("click", (e) => {
  const contenedor = document.getElementById("contenedorModal");
  if (!contenedor) return;

  // 1. ABRIR MODAL
  if (e.target.id === "btnNuevaHabitacion") {
    fetch("./Views/Modal-Habitaciones.php")
      .then((res) => res.text())
      .then((html) => {
        contenedor.innerHTML = html;
        contenedor.style.display = "flex";

        const modal = document.getElementById("modalHabitacion");
        if (modal) modal.style.display = "flex";
      });
  }

  if (
    e.target.id === "cerrarModalHabitacion" ||
    e.target.id === "btnCancelarHabitacion"
  ) {
    contenedor.style.display = "none";
    contenedor.innerHTML = "";
  }
});

// GUARDAR NUEVA HABITACIÓN
document.addEventListener("submit", async (e) => {
  if (e.target.id === "formNuevaHabitacion") {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    formData.append("accion", "guardar");

    try {
      // Enviamos al archivo enrutador independiente
      const res = await fetch("./Controllers/habitacionesGuardar.php", {
        method: "POST",
        body: formData,
      });

      const resultado = await res.json();

      if (resultado.exito) {
        Notificar(resultado.mensaje, "exito");

        // Cerrar modal automáticamente
        const contenedor = document.getElementById("contenedorModal");
        if (contenedor) {
          contenedor.style.display = "none";
          contenedor.innerHTML = "";
        }

        // Forzar una recarga de la grilla de habitaciones
        // (Como Habitaciones.js escucha 'change' en el document, esto actualiza la tabla)
        document.dispatchEvent(new Event("change"));
      } else {
        Notificar(
          resultado.mensaje || "Error desconocido al guardar.",
          "error",
        );
      }
    } catch (error) {
      console.error("Error al guardar habitación:", error);
      Notificar("Error de conexión con el servidor.", "error");
    }
  }
});
