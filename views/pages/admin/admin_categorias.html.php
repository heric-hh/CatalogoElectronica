<section class="section">
  <h3 class="title">Categorías</h3>
  <p class="subtitle">Consulta todas las categorías registradas en el sistema.</p>
  <a href="/admin/categorias/crear" class="button button-primary">Crear Categoria</a>
  <section class="section-table">
    <table class="table">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($categorias as $categoria) : ?>
        <tr>
          <td data-label="Nombre"><?php echo $categoria->categoria?></td>
          <td data-label="Acciones" class="form-actions">
            <form action="/admin/categorias/eliminar" method="post">
              <input type="hidden" name="id" value="<?php echo $categoria->id ?>">
              <input type="submit" value="Eliminar" class="button button-alerta">
            </form>
            <a href="/admin/categorias/editar?id=<?php echo $categoria->id ?>" class="button button-editar">
              Editar
            </a>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </section>
</section>