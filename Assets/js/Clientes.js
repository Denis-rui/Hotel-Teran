let listaClientes = [];
let textoBusquedaClientes = "";

// =============================
// UTILIDADES
// =============================
const normalizarTexto = (texto) => texto.toLowerCase().trim();

const obtenerClientesFiltrados = () => {
  const criterio = normalizarTexto(textoBusquedaClientes);
  if (!criterio) return listaClientes;

  return listaClientes.filter((cliente) =>
    normalizarTexto(cliente.nombre || "").includes(criterio),
  );
};

// =============================
// RENDER TABLA
// =============================
const renderizarTablaClientes = () => {
  const cuerpoTabla = document.getElementById("tabla-clientes-body");
  if (!cuerpoTabla) return;

  const clientes = obtenerClientesFiltrados();
  cuerpoTabla.innerHTML = "";

  clientes.forEach((cliente) => {
    cuerpoTabla.innerHTML += `
      <tr>
        <td>${cliente.id}</td>
        <td>${cliente.nombre || ""}</td>
        <td>${cliente.documento || ""}</td>
        <td>${cliente.gmail || ""}</td>
        <td>${cliente.telefono || ""}</td>
        <td>${cliente.nacionalidad || ""}</td>
        <td>
          <button class="btnEliminarCliente" data-id="${cliente.id}">🗑️</button>
        </td>
      </tr>
    `;
  });
};

// =============================
// API
// =============================
async function cargarClientes() {
  try {
    const res = await fetch("./Api/Controllers/listarclientes.php");
    if (!res.ok) {
      throw new Error(`HTTP ${res.status} al cargar clientes`);
    }
    const data = await res.json();

    listaClientes = data;
    renderizarTablaClientes();
  } catch (error) {
    console.error("Error cargando clientes:", error);
  }
}

function iniciarClientes() {
  console.log("INICIANDO CLIENTES");

  const app = document.getElementById("app");

  const btnNuevo = app?.querySelector("#btnNuevoCliente");
  const modal = app?.querySelector(".modal-cliente");
  const btnCancelar = app?.querySelector("#btn-cancelar-cliente");
  const form = app?.querySelector("#form-nuevo-editar-cliente");

  console.log("btnNuevo:", btnNuevo);
  console.log("modal:", modal);

  if (!btnNuevo || !modal) {
    console.warn("Modal o botón no encontrados");
    return;
  }

  btnNuevo.addEventListener("click", () => {
    modal.style.display = "flex";
  });

  if (btnCancelar) {
    btnCancelar.addEventListener("click", () => {
      modal.style.display = "none";
    });
  }

  if (form) {
    form.onsubmit = async (e) => {
      e.preventDefault();

      const formData = new FormData(form);

      const res = await fetch("./Api/Controllers/registrarcliente.php", {
        method: "POST",
        body: formData,
      });
      if (!res.ok) {
        throw new Error(`HTTP ${res.status} al registrar cliente`);
      }

      const data = await res.json();

      if (data.status === "success") {
        form.reset();
        modal.style.display = "none";
        cargarClientes();
      }
    };
  }

  cargarClientes();
}

window.iniciarClientes = iniciarClientes;
window.inicializarClientes = iniciarClientes;
