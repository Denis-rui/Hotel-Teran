const cambiarPagina = (id, archivo) => {
  fetch(archivo)
    .then((res) => res.text())
    .then((html) => {
      document.getElementById(id).innerHTML = html;

      if (id === "app" && archivo.includes("Usuarios.php")) {
        window.inicializarUsuarios();
      }
      if (id === "app" && archivo.includes("Configuracion.php")) {
        setTimeout(() => {
          window.inicializarConfiguraciones();
        }, 0);
      }
      if (
        id === "app" &&
        (archivo.includes("Dashboard.php") || archivo.includes("Reservas.php"))
      ) {
        setTimeout(() => {
          window.configurarBtnNuevaReserva?.();
        }, 0);
      }
      if (id === "app" && archivo.includes("Habitaciones.php")) {
        setTimeout(() => {
          console.log("Configurando btn nueva habitacion");
          window.configurarBtnNuevaHabitacion?.();
        }, 0);
      }

      if (id === "app" && archivo.includes("Reservas.php")) {
        setTimeout(() => {
          window.inicializarReservas?.();
        }, 0);
      }

      if (id === "app" && archivo.includes("Clientes.php")) {
        setTimeout(() => {
          window.inicializarClientes?.();
        }, 0);
      }
    })
    .catch((error) => console.error("Error cargando página:", error));
};

// Exponer en window para que sea accesible desde otros scripts
window.cambiarPagina = cambiarPagina;

window.addEventListener("DOMContentLoaded", () => {
  const yaLogueado = document.getElementById("nav");

  if (yaLogueado) {
    // 🔥 YA HAY NAV → usuario logueado
    cambiarPagina("app", "./public/views/Dashboard.php");
  }
});

const permisosUsuario = () => {
  const tipoUsuario = localStorage.getItem("tipoUsuario");
  const opcionesNav = document.querySelectorAll("[data-rol]");
  opcionesNav.forEach((opcion) => {
    const rolesPermitidos = opcion.getAttribute("data-rol").split(",");
    if (!rolesPermitidos.includes(tipoUsuario)) {
      opcion.style.display = "none";
    }
  });
};
