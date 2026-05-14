<section class="usuarios">
  <header class="header-usuarios">
    <h2>Clientes</h2>
    <button id="btnNuevoCliente" type="button" class="boton-nuevo-usuario">
      Nuevo Cliente
    </button>
  </header>

  <div class="buscar">
    <input
      id="inputBuscarCliente"
      type="text"
      placeholder="🔍 Buscar cliente" />
  </div>

  <div class="tabla">
    <table class="tbl-usuarios">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>DNI</br>
            Pasaporte</th>
          <th>Gmail</th>
          <th>Telefono</th>
          <th>País</br>
            Lugar de Orgen
          </th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody id="tabla-clientes-body"></tbody>
    </table>
  </div>
</section>
<?php include 'modal-clientes.php'; ?>