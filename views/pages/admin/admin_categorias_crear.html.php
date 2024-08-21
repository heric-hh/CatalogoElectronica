<section class="section">
  <h3 class="title">Crear Categoría</h3>
  <p class="subtitle">Crea una categoría para tus productos.</p>
  <a href="/admin/categorias" class="button button-primary">Volver</a>
  <?php foreach($errores as $error) : ?>
    <div class="alerta error">
      <?php echo $error ?>
    </div>
  <?php endforeach ?>
  <form action="/admin/categorias/crear" method="post" class="form">
  <?php require_once __DIR__ . "/../layout/form_categorias.html.php" ?>
  <input type="submit" value="Guardar Categoría" class="button button-primary">
  </form>
</section>