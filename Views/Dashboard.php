<section class="main-content dashboard">
  <!-- HEADER -->
  <header class="main-header">
    <div class="header-left">
      <h1>DASHBOARD - TERAN HOTEL</h1>
    </div>

    <div class="header-right">
      <button id="btnNuevaReserva" class="btn btn-nueva-reserva">
        Nueva Reserva
      </button>
    </div>
  </header>

  <!-- WIDGETS SUPERIORES -->
  <section class="dashboard-widgets-top">
    <!-- Widget 1: Habitaciones -->
    <div class="widget widget-red">
      <div class="widget-icon">🛏️</div>
      <div class="widget-info">
        <p class="widget-label">Habitaciones disponibles</p>
      </div>
    </div>

    <!-- Widget 2: Reservas -->
    <div class="widget widget-green">
      <div class="widget-icon">🗓️</div>
      <div class="widget-info">
        <p class="widget-label">Reservas Activas</p>
      </div>
    </div>

    <!-- Widget 3: Ingresos -->
    <div class="widget widget-gray">
      <div class="widget-icon">💰📈</div>
      <div class="widget-info">
        <p class="widget-label">Ingreso Mensual</p>
      </div>
    </div>
  </section>

  <!-- COLUMNAS INFERIORES -->
  <div class="content-columns">
    <!-- COLUMNA IZQUIERDA: Actividades Recientes -->
    <div class="column-left">
      <h3 class="section-title">Actividades Recientes</h3>

      <div class="activity-pill pill-blue">
        <div class="activity-icon blue-icon">
          <span>➔</span>
        </div>
        <p>Check in (hoy)</p>
      </div>

      <div class="activity-pill pill-purple">
        <div class="activity-icon purple-icon">
          <span>⬅</span>
        </div>
        <p>Check out (hoy)</p>
      </div>
    </div>

    <!-- COLUMNA DERECHA: Resumen del día -->
    <div class="column-right">
      <section class="card summary-card">
        <div class="card-header">
          <h3 class="summary-title">Resumen del día</h3>
        </div>
        <div class="card-body">
          <ul class="summary-list">
            <li>
              <div class="summary-item-left">
                <span class="summary-icon">🛏️</span>
                <span>Habitaciones por limpiar</span>
              </div>
              <span class="summary-value">12</span>
            </li>
            <li>
              <div class="summary-item-left">
                <span class="summary-icon">📍</span>
                <span>Lugar de procedencia</span>
              </div>
              <span class="summary-value">18</span>
            </li>
            <li>
              <div class="summary-item-left">
                <span class="summary-icon">🏘️</span>
                <span>Estancia mas corta(dias)</span>
              </div>
              <span class="summary-value">7</span>
            </li>
            <li>
              <div class="summary-item-left">
                <span class="summary-icon">💰</span>
                <span>Ingreso del dia</span>
              </div>
              <span class="summary-value">S/ 40.00</span>
            </li>
          </ul>
        </div>
      </section>
    </div>
  </div>
</section>