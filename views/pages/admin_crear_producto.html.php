<section class="section">
  <h3 class="title">Crear Producto</h3>
  <p class="subtitle">Crea un nuevo registro para un producto.</p>
  <a href="/admin/productos" class="button button-primary">Volver</a>
  <?php foreach($errores as $error) : ?>
    <div class="alerta error">
      <?php echo $error ?>
    </div>
  <?php endforeach ?>
  <form action="/admin/productos/crear" method="post" class="form">
    <?php require_once __DIR__ . "/../layout/form_productos.html.php"; ?>
    <input type="submit" value="Guardar Producto" class="button button-primary">
  </form>
</section>