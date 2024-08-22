<section id="productos" class="section">
  <h3 class="title">Productos</h3>
  <p class="subtitle">Lo mejor en electrónica: Productos para cada entusiasta.</p>
  <!-- Añadir funcionalidad de filtro -->
  <form action="" id="filters-form" method="GET">
    <div class="filter-wrapper">
      <label for="categoria" class="filter-label">Categoría</label>
      <select name="categoria" id="categoria" class="filter-select">
        <option value="0">Todas</option>
        <?php foreach($categorias as $categoria): ?>
            <option value="<?php echo htmlspecialchars((string)$categoria->id); ?>" 
                <?php echo (int)($_GET['categoria'] ?? 0) === $categoria->id ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($categoria->categoria); ?>
            </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="filter-wrapper">
      <label for="marca" class="filter-label">Marca</label>
      <select name="marca" id="marca" class="filter-select">
        <option value="0">Todas</option>
        <?php foreach($marcas as $marca): ?>
            <option value="<?php echo htmlspecialchars((string)$marca->id); ?>" 
              <?php echo (int)($_GET['marca'] ?? 0) === $marca->id ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($marca->marca); ?>
            </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="filter-wrapper">
      <label for="precio-orden" class="filter-label">Precio</label>
      <select name="precio-orden" id="precio-orden" class="filter-select">
        <option value="">Seleccionar</option>
        <option value="asc" <?php echo $precioOrden === "asc" ? "selected" : "" ?>> Menor a Mayor</option>
        <option value="desc" <?php echo $precioOrden === "desc" ? "selected" : "" ?>> Mayor a Menor</option>
      </select>
    </div>
  </form>

  <div class="productos-grid">
    <?php foreach($productos as $producto) : ?>
    <a href="#" class="producto-card">
      <div class="img-wrapper">
        <picture>
          <source srcset="<?php echo IMAGENES_DIR . $producto->imagen ?>.webp" type="image/webp">
          <img src="<?php echo IMAGENES_DIR . $producto->imagen ?>.webp" alt="Imagen del Producto" loading="lazy">
        </picture>
      </div>
      <span class="card-marca"><?php echo $producto->marca_nombre ?></span>
      <span class="card-nombre"><?php echo $producto->nombre?> </span>
      <span class="card-descripcion"><?php echo $producto->descripcion_corta?></span>
      <span class="card-precio"><?php echo $producto->precio ?></span>
    </a>
    <?php endforeach ?>
  </div>

  <div class="pagination">
      <?php if ($paginaActual > 1): ?>
          <a href="?pagina=<?php echo $paginaActual - 1; ?>">Anterior</a>
      <?php endif; ?>
      <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
          <a href="?pagina=<?php echo $i; ?>" class="<?php echo $i === $paginaActual ? 'active' : ''; ?>">
              <?php echo $i; ?>
          </a>
      <?php endfor; ?>
      <?php if ($paginaActual < $totalPaginas): ?>
          <a href="?pagina=<?php echo $paginaActual + 1; ?>">Siguiente</a>
      <?php endif; ?>
    </div>

</section>