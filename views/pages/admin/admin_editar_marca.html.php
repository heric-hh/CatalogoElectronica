<section class="section">
  <h3 class="title">Editar Marca</h3>
  <p class="subtitle">Edita la marca para tus productos.</p>
  <a href="/admin/marca" class="button button-primary">Volver</a>
  <?php foreach( $errores as $error ): ?>
    <div class="alerta error">
      <?php echo $error; ?>
    </div>
  <?php endforeach ?>
  <form action="" method="post" class="form">
    <?php require_once __DIR__ . "/../../layout/forms/form_marcas.html.php" ?>
    <input type="submit" value="Editar Marca" class="button button-secondary">
  </form>
</section>