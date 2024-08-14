<section id="productos" class="section">
  <h3 class="title">Productos</h3>
  <p class="subtitle">Lo mejor en electrónica: Productos para cada entusiasta.</p>
  <!-- Añadir funcionalidad de filtro -->
  <form action="" id="filters-form" method="GET">
    <div class="filter-wrapper">
      <label for="categoria" class="filter-label">Categoría</label>
      <select name="categoria" id="categoria" class="filter-select">
        <option value="">Todas</option>
        <option value="1">Opción 1</option>
        <option value="2">Opción 2</option>
      </select>
    </div>

    <div class="filter-wrapper">
      <label for="marca" class="filter-label">Marca</label>
      <select name="marca" id="marca" class="filter-select">
        <option value="">Todas</option>
        <option value="1">Opcion 1</option>
        <option value="2">Opcion 2</option>
      </select>
    </div>

    <div class="filter-wrapper">
      <label for="precio-orden" class="filter-label">Precio</label>
      <select name="precio-orden" id="precio-orden" class="filter-select">
        <option value="">Seleccionar</option>
        <option value="asc">Menor A Mayor</option>
        <option value="desc">Mayor A Menor</option>
      </select>
    </div>
  </form>

  <div class="productos-grid">
    <a href="#" class="producto-card">
      <div class="img-wrapper">
        <img src="./views/assets/img/gamepadSinFondo.png" alt="gamepad">
      </div>
      <span class="card-marca">Marca</span>
      <span class="card-nombre">Nombre del producto</span>
      <span class="card-descripcion">Descripcion</span>
      <span class="card-precio">$200.00</span>
    </a>

    <a href="#" class="producto-card">
      <div class="img-wrapper">
        <img src="./views/assets/img/gamepadSinFondo.png" alt="gamepad">
      </div>
      <span class="card-marca">Marca</span>
      <span class="card-nombre">Nombre del producto</span>
      <span class="card-descripcion">Descripcion</span>
      <span class="card-precio">$200.00</span>
    </a>
  </div>

</section>