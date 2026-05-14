<section class="modal-cliente" style="display:none;">
  <div class="contenedor-modal" role="dialog" aria-modal="true">
    <h3 id="titulo-modal-cliente" class="titulo-modal">Nuevo Cliente</h3>

    <form id="form-nuevo-editar-cliente" class="formulario-modal" novalidate>

      <input type="hidden" id="id-cliente" name="idCliente" />

      <div class="label-input-modal">
        <label for="nombre-cliente">Nombre</label>
        <input
          type="text"
          id="nombre-cliente"
          name="nombre"
          class="input-modal"
          required />
      </div>

      <div class="label-input-modal">
        <label for="dni-cliente">DNI | Pasaporte</label>
        <input
          type="text"
          id="dni-cliente"
          name="dni"
          class="input-modal"
          required />
      </div>

      <div class="label-input-modal">
        <label for="gmail-cliente">Gmail</label>
        <input
          type="email"
          id="gmail-cliente"
          name="gmail"
          class="input-modal"
          required />
      </div>

      <div class="label-input-modal">
        <label for="telefono-cliente">Teléfono</label>
        <input
          type="tel"
          id="telefono-cliente"
          name="telefono"
          class="input-modal"
          required />
      </div>

      <div class="label-input-modal">
        <label for="nacionalidad-cliente">País | Lugar de Origen</label>
        <input
          type="text"
          id="nacionalidad-cliente"
          name="nacionalidad"
          class="input-modal"
          required />
      </div>

      <div class="label-input-modal">
        <label for="reservaciones-cliente">Reservaciones</label>
        <input
          type="number"
          id="reservaciones-cliente"
          name="reservaciones"
          class="input-modal" />
      </div>

      <div class="label-input-modal">
        <label for="metodo-pago-cliente">Método de Pago</label>
        <select
          id="metodo-pago-cliente"
          name="metodoPago"
          class="input-modal"
          required>
          <option value="">Seleccione</option>
          <option value="efectivo">Efectivo</option>
          <option value="tarjeta">Tarjeta</option>
          <option value="transferencia">Transferencia</option>
        </select>
      </div>

      <div id="error-exito-modal-cliente" class="div-mensaje-exito-error"></div>

      <button type="button" id="btn-cancelar-cliente" class="btn-cancelar btn">
        Cancelar
      </button>

      <button type="submit" class="btn-guardar btn">
        Guardar Cliente
      </button>
    </form>
  </div>
</section>