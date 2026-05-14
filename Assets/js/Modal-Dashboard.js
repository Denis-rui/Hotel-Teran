window.abrirModalReserva = (modo = "nuevo", datos = null) => {
  const contenedor = document.getElementById("contenedorModal");

  fetch("./Views/Modal-Dashboard.php")
    .then((res) => res.text())
    .then((html) => {
      contenedor.innerHTML = html;

      const modal = document.getElementById("modalReserva");
      const form = document.getElementById("formReserva");
      const cerrar = document.getElementById("cerrarModal");
      const btnContinuarPago = document.getElementById("btnContinuarPago");
      const inputBuscarCliente = document.getElementById("buscarCliente");
      const selectorCliente = document.getElementById("selectorClienteReserva");
      const idClienteReserva = document.getElementById("idClienteReserva");
      const campoNombre = document.getElementById("nombre");
      const campoEmail = document.getElementById("email");
      const mensajeBusquedaCliente = document.getElementById(
        "mensajeBusquedaCliente",
      );

      let clientes = [];

      const mostrarClientes = () => {
        selectorCliente.innerHTML =
          '<option value="">Seleccionar cliente</option>';

        if (clientes.length === 0) {
          selectorCliente.innerHTML +=
            '<option value="" disabled>Sin resultados</option>';
          return;
        }

        clientes.forEach((cliente) => {
          selectorCliente.innerHTML += `<option value="${cliente.id}">${cliente.nombre}</option>`;
        });
      };

      const cargarClientes = (texto = "") => {
        fetch(
          `./Controllers/buscar_clientes_reserva.php?q=${encodeURIComponent(texto)}`,
        )
          .then((res) => {
            if (!res.ok) {
              throw new Error(`HTTP ${res.status} al buscar clientes`);
            }
            return res.json();
          })
          .then((respuesta) => {
            if (respuesta.error) {
              alert("No se pudo cargar clientes");
              return;
            }

            clientes = respuesta.clientes || [];
            mostrarClientes();

            if (texto !== "" && clientes.length === 0) {
              mensajeBusquedaCliente.textContent =
                "No se encontraron clientes.";
            } else {
              mensajeBusquedaCliente.textContent =
                "Selecciona un cliente de la lista.";
            }
          })
          .catch(() => {
            mensajeBusquedaCliente.textContent =
              "No se pudieron cargar los clientes.";
          });
      };

      const seleccionarCliente = () => {
        const idSeleccionado = selectorCliente.value;

        idClienteReserva.value = "";

        if (!idSeleccionado) {
          campoNombre.value = "";
          campoEmail.value = "";
          return;
        }

        for (let i = 0; i < clientes.length; i++) {
          if (String(clientes[i].id) === String(idSeleccionado)) {
            idClienteReserva.value = clientes[i].id;
            campoNombre.value = clientes[i].nombre || "";
            campoEmail.value = clientes[i].gmail || clientes[i].correo || "";
            break;
          }
        }

        mensajeBusquedaCliente.textContent =
          "Cliente seleccionado correctamente.";
      };

      const continuarPago = () => {
        const cliente = selectorCliente.value;
        const nombre = campoNombre.value.trim();
        const email = campoEmail.value.trim();
        const checkIn = document.getElementById("fechaEntrada").value;
        const horaEntrada = document.getElementById("horaEntrada").value;
        const checkOut = document.getElementById("fechaSalida").value;
        const horaSalida = document.getElementById("horaSalida").value;
        const habitacion = document.getElementById(
          "seleccioneHabitacion",
        ).value;

        if (!cliente) {
          alert("Selecciona un cliente");
          return;
        }
        if (!nombre) {
          alert("Nombre y apellido obligatorio");
          return;
        }
        if (!email) {
          alert("Correo electronico obligatorio");
          return;
        }
        if (!checkIn || !horaEntrada || !checkOut || !horaSalida) {
          alert("Completa check-in y check-out");
          return;
        }
        if (!habitacion) {
          alert("Selecciona una habitacion");
          return;
        }

        const textoClienteSeleccionado =
          selectorCliente.options[selectorCliente.selectedIndex].text;

        abrirModalPagoConDatos({
          cliente: cliente,
          clienteTexto: textoClienteSeleccionado,
          nombre: nombre,
          email: email,
          checkIn: checkIn,
          horaEntrada: horaEntrada,
          checkOut: checkOut,
          horaSalida: horaSalida,
          habitacion: habitacion,
        });

        modal.style.display = "none";
        contenedor.style.display = "none";
      };

      contenedor.style.display = "block";
      modal.style.display = "block";

      if (modo === "nuevo") {
        form.reset();
        document.querySelector(".titulo-modal").textContent = "Nueva Reserva";
      }

      if (modo === "editar" && datos) {
        document.querySelector(".titulo-modal").textContent = "Editar Reserva";
        btnContinuarPago.textContent = "Actualizar";
        campoNombre.value = datos.cliente || "";
        campoEmail.value = datos.email || "";
      }

      cargarClientes();

      inputBuscarCliente.addEventListener("input", () => {
        cargarClientes(inputBuscarCliente.value.trim());
      });

      selectorCliente.addEventListener("change", seleccionarCliente);

      cerrar.addEventListener("click", () => {
        modal.style.display = "none";
        contenedor.style.display = "none";
      });

      btnContinuarPago.addEventListener("click", (e) => {
        e.preventDefault();
        continuarPago();
      });

      form.addEventListener("submit", (e) => {
        e.preventDefault();
        continuarPago();
      });

      const btnNuevoCliente = document.getElementById(
        "btn-registrar-cliente-manual",
      );
      if (btnNuevoCliente) {
        btnNuevoCliente.addEventListener("click", () => {
          window.abrirModalCliente("nuevo");
        });
      }
    });
};

window.configurarBtnNuevaReserva = () => {
  const btn = document.getElementById("btnNuevaReserva");
  if (!btn) return;

  btn.addEventListener("click", () => {
    window.abrirModalReserva("nuevo");
  });
};

// Funcion para abrir modal de pago con datos de reserva
const abrirModalPagoConDatos = (datosReserva) => {
  if (typeof window.abrirModalPago !== "function") {
    alert("No se pudo abrir el modulo de pago");
    return;
  }

  window.abrirModalPago(datosReserva);
};
