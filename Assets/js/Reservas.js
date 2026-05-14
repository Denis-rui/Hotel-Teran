window.inicializarReservas = () => {
  configurarEventosReservas();
  const buscarReserva = document.getElementById("inputBuscarReserva");
  const estadoSeleccionadoFiltro = document.getElementById("filtroEstado");

  if (!buscarReserva || !estadoSeleccionadoFiltro) return;

  const aplicarFiltros = () => {
    const nombreBuscar = buscarReserva.value.toLowerCase();
    const estadoSeleccionado = estadoSeleccionadoFiltro.value.toLowerCase();
    const filas = document.querySelectorAll("#contenido-reservas tr");
    filas.forEach((fila) => {
      const nombre = fila.children[0].textContent.toLowerCase();
      const estado = fila.children[5].textContent.toLocaleLowerCase();
      if (
        nombre.includes(nombreBuscar) &&
        (estadoSeleccionado === "" || estado === estadoSeleccionado)
      ) {
        fila.style.display = "";
      } else {
        fila.style.display = "none";
      }
    });
  };

  buscarReserva.addEventListener("input", () => {
    aplicarFiltros();
  });

  estadoSeleccionadoFiltro.addEventListener("change", () => {
    aplicarFiltros();
  });
};
const configurarEventosReservas = () => {
  const btnNuevaReserva = document.getElementById("btnNuevaReserva");
  const cuerpoTabla = document.getElementById("contenido-reservas");

  if (btnNuevaReserva) {
    btnNuevaReserva.addEventListener("click", () => {
      window.abrirModalReserva("nuevo");
    });
  }

  if (cuerpoTabla) {
    cuerpoTabla.addEventListener("click", (e) => {
      const btnEditar = e.target.closest(".boton-editar-reserva");
      if (btnEditar) {
        const fila = btnEditar.closest("tr");
        const id = Number(fila.dataset.id);
        window.abrirModalReserva("editar", { id });
        return;
      }

      // Evento para botón de pago
      const btnPago = e.target.closest(".boton-pago-tabla");
      if (btnPago) {
        const idReserva = btnPago.dataset.id;

        // Guardar el ID en el modal de pago
        const formPago = document.getElementById("formPago");
        if (formPago) {
          formPago.dataset.idReserva = idReserva;
          formPago.dataset.modoNuevo = "false"; // Indica que no es reserva nueva
        }

        // Abrir modal de pago
        if (typeof window.abrirModalPago === "function") {
          window.abrirModalPago({ idReserva });
        } else {
          alert("No se pudo abrir el modulo de pago");
        }
      }
    });
  }
};

document.addEventListener("click", (e) => {
  const btnEditar = e.target.closest(".boton-editar-reserva");
  if (!btnEditar) return;

  const fila = btnEditar.closest("tr");

  const datos = {
    id: fila.dataset.id,
    cliente: fila.dataset.cliente,
    habitacion: fila.dataset.habitacion,
    checkIn: fila.dataset.checkin,
    checkOut: fila.dataset.checkout,
    total: fila.dataset.total,
    email: fila.dataset.email,
    estado: fila.dataset.estado,
  };

  window.abrirModalReserva("editar", datos);
});
