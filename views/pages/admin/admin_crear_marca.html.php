<section class="section">
  <h3 class="title">Crear Marca</h3>
  <p class="subtitle">Crea una nueva marca para tus productos.</p>
  <a href="/admin/marcas" class="button button-primary">Volver</a>
  <?php foreach($errores as $error) : ?>
    <div class="alerta error">
      <?php echo $error ?>
    </div>
  <?php endforeach ?>
  <form action="/admin/marcas/crear" method="post" class="form">
    <?php require_once __DIR__ . "/../layout/form_marcas.html.php" ?>
    <input type="submit" value="Guardar Marca" class="button button-primary">
  </form>
</section>