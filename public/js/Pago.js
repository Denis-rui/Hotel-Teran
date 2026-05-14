let eventosPagoConfigurados = false;

const asegurarModalPago = async () => {
  let modal = document.getElementById("modalPago");
  if (modal) return modal;

  const respuesta = await fetch("./public/views/Modal-Pago.php");
  const html = await respuesta.text();

  const wrapper = document.createElement("div");
  wrapper.id = "contenedorModalPago";
  wrapper.innerHTML = html;
  document.body.appendChild(wrapper);

  modal = document.getElementById("modalPago");
  return modal;
};

const poblarCamposOcultosReserva = (datos = {}) => {
  const formPago = document.getElementById("formPago");
  if (formPago) {
    if (datos.idReserva) {
      formPago.dataset.idReserva = datos.idReserva;
      formPago.dataset.modoNuevo = "false";
    } else {
      delete formPago.dataset.idReserva;
      formPago.dataset.modoNuevo = "true";
    }
  }

  const mapa = {
    pagoCliente: datos.cliente || "",
    pagoNombre: datos.nombre || "",
    pagoEmail: datos.email || "",
    pagoCheckIn: datos.checkIn || "",
    pagoHoraEntrada: datos.horaEntrada || "",
    pagoCheckOut: datos.checkOut || "",
    pagoHoraSalida: datos.horaSalida || "",
    pagoHabitacion: datos.habitacion || "",
    pagoTotalReserva: datos.totalReserva || "",
  };

  Object.entries(mapa).forEach(([id, valor]) => {
    const campo = document.getElementById(id);
    if (campo) campo.value = valor;
  });

  const infoCliente = document.getElementById("infoPagoCliente");
  const infoHabitacion = document.getElementById("infoPagoHabitacion");
  const infoCheckin = document.getElementById("infoPagoCheckin");
  const infoCheckout = document.getElementById("infoPagoCheckout");
  const infoMonto = document.getElementById("infoPagoMonto");
  const infoPagado = document.getElementById("infoPagoPagado");

  if (infoCliente)
    infoCliente.textContent = datos.clienteTexto || datos.nombre || "---";
  if (infoHabitacion) {
    infoHabitacion.textContent = datos.habitacion
      ? `Habitacion ${datos.habitacion}`
      : "---";
  }
  if (infoCheckin) {
    infoCheckin.textContent = datos.checkIn
      ? `${datos.checkIn} ${datos.horaEntrada || ""}`.trim()
      : "---";
  }
  if (infoCheckout) {
    infoCheckout.textContent = datos.checkOut
      ? `${datos.checkOut} ${datos.horaSalida || ""}`.trim()
      : "---";
  }
  if (infoMonto) {
    infoMonto.textContent = datos.totalReserva
      ? `$${datos.totalReserva}`
      : "$---";
  }
  if (infoPagado) infoPagado.textContent = "$0.00";
};

const configurarEventosPago = () => {
  if (eventosPagoConfigurados) return;

  const modalPago = document.getElementById("modalPago");
  const cerrarBtn = document.getElementById("cerrarModalPago");
  const cancelarBtn = document.getElementById("btnCancelarPago");
  const formPago = document.getElementById("formPago");

  if (cerrarBtn) {
    cerrarBtn.addEventListener("click", window.cerrarModalPago);
  }

  if (cancelarBtn) {
    cancelarBtn.addEventListener("click", window.cerrarModalPago);
  }

  if (modalPago) {
    modalPago.addEventListener("click", (e) => {
      if (e.target === modalPago) {
        window.cerrarModalPago();
      }
    });
  }

  if (formPago) {
    formPago.addEventListener("submit", (e) => {
      e.preventDefault();

      const montoPago =
        document.getElementById("montoPago")?.value.trim() || "";
      const metodoPago =
        document.getElementById("metodoPago")?.value.trim() || "";
      const fechaPago =
        document.getElementById("fechaPago")?.value.trim() || "";

      if (!montoPago) {
        alert("El monto es requerido");
        return;
      }

      if (!metodoPago) {
        alert("Debe seleccionar un metodo de pago");
        return;
      }

      if (!fechaPago) {
        alert("Debe ingresar la fecha del pago");
        return;
      }

      if (parseFloat(montoPago) <= 0) {
        alert("El monto debe ser mayor a 0");
        return;
      }

      const esReservaNueva = formPago.dataset.modoNuevo === "true";
      if (esReservaNueva) {
        const cliente =
          document.getElementById("pagoCliente")?.value.trim() || "";
        const habitacion =
          document.getElementById("pagoHabitacion")?.value.trim() || "";
        const checkIn =
          document.getElementById("pagoCheckIn")?.value.trim() || "";
        const checkOut =
          document.getElementById("pagoCheckOut")?.value.trim() || "";

        if (!cliente || !habitacion || !checkIn || !checkOut) {
          alert(
            "Faltan datos de la reserva. Vuelve a abrir la reserva y selecciona un cliente valido.",
          );
          return;
        }
      }

      alert("Pago validado correctamente");
      window.cerrarModalPago();
    });
  }

  eventosPagoConfigurados = true;
};

window.abrirModalPago = async (datosReserva = {}) => {
  const modalPago = await asegurarModalPago();
  if (!modalPago) return;

  poblarCamposOcultosReserva(datosReserva);

  const fechaPago = document.getElementById("fechaPago");
  if (fechaPago && !fechaPago.value) {
    fechaPago.valueAsDate = new Date();
  }

  configurarEventosPago();
  modalPago.classList.add("activo");
};

window.cerrarModalPago = () => {
  const modalPago = document.getElementById("modalPago");
  const formPago = document.getElementById("formPago");

  if (modalPago) {
    modalPago.classList.remove("activo");
  }

  if (formPago) {
    formPago.reset();
  }
};
