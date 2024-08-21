<section class="section">
  <h3 class="title">Productos</h3>
  <p class="subtitle">Administra la información de tus productos</p>
  <section class="section-buttons">
    <a href="/admin/productos/crear" class="button button-primary">Crear Producto</a>
  </section>
  <section class="section-table">
    <table class="table">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Categoría</th>
          <th>Marca</th>
          <th>Descripción</th>
          <th>Disponibilidad</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($productosS as $producto) : ?>
        <tr>
          <td data-label="Nombre"><?php echo $producto->nombre ?></td>
          <td data-label="Categoría"><?php echo $producto->categoria_nombre?></td>
          <td data-label="Marca"><?php echo $producto->marca_nombre?></td>
          <td data-label="Descripción"><?php echo $producto->descripcion_corta?></td>
          <td data-label="Disponible"><?php echo $producto->disponible ?></td>
          <td data-label="Acciones">
            <form action="/admin/productos/eliminar" method="post">
              <input type="hidden" name="id" value="<?php echo $producto->id ?>">
              <input type="submit" value="Eliminar" class="button">
            </form>
            <a href="/admin/productos/editar?id=<?php echo $producto->id?>" class="button">
              Editar
            </a>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>

    <!-- Controles de Paginación -->
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
</section>