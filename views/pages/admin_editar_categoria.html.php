<section class="section">
  <h3 class="title">Editar Categoría</h3>
  <p class="subtitle">Edita la categoría para tus productos.</p>
  <a href="/admin/categorias" class="button button-primary">Volver</a>
  <?php foreach( $errores as $error ): ?>
    <div class="alerta error">
      <?php echo $error; ?>
    </div>
  <?php endforeach ?>
  <form action="" method="post" class="form">
    <?php require_once __DIR__ . "/../layout/form_categorias.html.php" ?>
    <input type="submit" value="Editar Categoría" class="button button-secondary">
  </form>
</section>