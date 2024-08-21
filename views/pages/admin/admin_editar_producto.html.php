<section class="section">
  <h3 class="title">Editar Producto</h3>
  <p class="subtitle">Edita la información de tu producto.</p>
  <a href="/admin/productos" class="button button-primary">Volver</a>
  <?php foreach( $errores as $error ): ?>
    <div class="alerta error">
      <?php echo $error; ?>
    </div>
  <?php endforeach ?>
  <form action="/admin/productos/editar" method="post" class="form" enctype="multipart/form-data">
    <?php require_once __DIR__ . "/../../layout/forms/form_productos.html.php"; ?>
    <input type="submit" value="Editar Producto" class="button button-secondary">
  </form>
</section>