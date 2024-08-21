<section class="section">
  <h1 class="title">Marcas</h1>
  <p class="subtitle">Adminstra las marcas para tus productos.</p>
  <a href="/admin/marcas/crear" class="button button-primary">Crear Marca</a>
  <section class="section-table">
    <table class="table">
      <thead>
        <tr>
          <th>Marca</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($marcas as $marca) : ?>
        <tr>
          <td data-label="Marca"><?php echo $marca->marca?></td>
          <td data-label="Acciones">
            <form action="/admin/marcas/eliminar" method="post">
              <input type="hidden" name="id" value="<?php echo $marca->id ?>">
              <input type="submit" value="Eliminar" class="button">
            </form>
            <a href="/admin/marcas/editar?id=<?php echo $marca->id ?>" class="button">
              Editar
            </a>
          </td>
        </tr>
        <?php endforeach ?>
      </tbody>
    </table>
  </section>

</section>