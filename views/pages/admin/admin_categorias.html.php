<section class="section">
  <h3 class="title">Lista de categorías</h3>
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
          <td data-label="Acciones">
            <form action="/admin/categorias/eliminar" method="post">
              <input type="hidden" name="id" value="<?php echo $categoria->id ?>">
              <input type="submit" value="Eliminar" class="button">
            </form>
            <a href="/admin/categorias/editar?id=<?php echo $categoria->id ?>" class="button">
              Editar
            </a>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </section>
</section>