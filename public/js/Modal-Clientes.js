let modoFormularioCliente = "nuevo";

const obtenerContenedorModalCliente = () => {
  let contenedor = document.getElementById("contenedor-modal-cliente");

  if (!contenedor) {
    contenedor = document.createElement("div");
    contenedor.id = "contenedor-modal-cliente";
    document.body.appendChild(contenedor);
  }

  return contenedor;
};

const mostrarMensajeModalCliente = (mensaje, tipo = "error") => {
  const elemento = document.getElementById("mensaje-modal-cliente");
  if (!elemento) return;

  elemento.textContent = mensaje;
  elemento.classList.remove("error", "exito");

  if (tipo) elemento.classList.add(tipo);
};

const limpiarMensajeModalCliente = () => {
  mostrarMensajeModalCliente("", "");
};

const obtenerDatosFormularioCliente = () => ({
  id: document.getElementById("id-cliente").value.trim(),
  nombre: document.getElementById("nombre-cliente").value.trim(),
  documento: document.getElementById("dni-cliente").value.trim(),
  gmail: document.getElementById("gmail-cliente").value.trim(),
  telefono: document.getElementById("telefono-cliente").value.trim(),
  nacionalidad: document.getElementById("nacionalidad-cliente").value.trim(),
  reservaciones: Number(document.getElementById("reservaciones-cliente").value),
  metodoPago: document.getElementById("metodo-pago-cliente").value,
});

const validarFormularioCliente = (datos) => {
  const reglas = {
    nombre: /^[a-zA-ZÀ-ÿ\s]{3,}$/,
    documento: /^\d{8}$/,
    gmail: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
    telefono: /^\d{9}$/,
  };

  if (!reglas.nombre.test(datos.nombre)) {
    return "Nombre inválido";
  }

  if (!reglas.documento.test(datos.documento)) {
    return "DNI inválido (8 dígitos)";
  }

  if (!reglas.gmail.test(datos.gmail)) {
    return "Correo inválido";
  }

  if (!reglas.telefono.test(datos.telefono)) {
    return "Teléfono inválido (9 dígitos)";
  }

  return "";
};

const completarFormularioCliente = (datos = null) => {
  const titulo = document.getElementById("titulo-modal-cliente");
  if (!titulo) return;

  if (modoFormularioCliente === "editar" && datos) {
    titulo.textContent = "Editar Cliente";

    document.getElementById("id-cliente").value = datos.id;
    document.getElementById("nombre-cliente").value = datos.nombre;
    document.getElementById("dni-cliente").value = datos.documento;
    document.getElementById("gmail-cliente").value = datos.gmail || "";
    document.getElementById("telefono-cliente").value = datos.telefono || "";
    document.getElementById("nacionalidad-cliente").value =
      datos.nacionalidad || "";
    document.getElementById("reservaciones-cliente").value =
      datos.reservaciones || 0;
    document.getElementById("metodo-pago-cliente").value = datos.metodoPago;

    return;
  }

  titulo.textContent = "Nuevo Cliente";
};

const manejarEnvioFormularioCliente = (e) => {
  e.preventDefault();
  limpiarMensajeModalCliente();

  const datos = obtenerDatosFormularioCliente();
  const error = validarFormularioCliente(datos);

  if (error) {
    mostrarMensajeModalCliente(error, "error");
    return;
  }

  if (modoFormularioCliente === "editar") {
    window.actualizarClienteExistente?.(datos);
  } else {
    window.registrarClienteNuevo?.(datos);
  }

  cerrarModalCliente();
};

const configurarEventosModalCliente = () => {
  const form = document.getElementById("form-nuevo-editar-cliente");
  const btnCancelar = document.getElementById("btn-cancelar-cliente");

  form.addEventListener("submit", manejarEnvioFormularioCliente);
  btnCancelar.addEventListener("click", cerrarModalCliente);
};

const abrirModalCliente = (modo, datos = null) => {
  modoFormularioCliente = modo;
  const contenedor = obtenerContenedorModalCliente();

  fetch("./public/views/Modal-Clientes.php")
    .then((res) => res.text())
    .then((html) => {
      contenedor.innerHTML = html;
      contenedor.style.display = "block";

      completarFormularioCliente(datos);
      configurarEventosModalCliente();
    })
    .catch((err) => console.error(err));
};

const cerrarModalCliente = () => {
  const elemento = document.getElementById("error-exito-modal-cliente");
  if (!contenedor) return;

  contenedor.style.display = "none";
  contenedor.innerHTML = "";
};

window.abrirModalCliente = abrirModalCliente;
window.cerrarModalCliente = cerrarModalCliente;
window.registrarClienteNuevo = (datos) => {
  fetch("./controllers/registrarcliente.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: new URLSearchParams(datos).toString(),
  })
    .then((res) => res.json())
    .then((respuesta) => {
      if (respuesta.status === "success") {
        alert(respuesta.message);
        cargarClientes(); // refresca la tabla
      } else {
        alert(respuesta.message);
      }
    })
    .catch((err) => console.error("Error:", err));
};
