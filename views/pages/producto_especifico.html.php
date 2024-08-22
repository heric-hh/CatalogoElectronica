<section class="section">
  <h3 class="title">Detalles del Producto</h3>
  <div class="img-container">
    <picture>
      <source srcset="<?php echo IMAGENES_DIR . $producto->imagen ?>.webp" type="image/webp">
      <img src="<?php echo IMAGENES_DIR . $producto->imagen ?>.webp" alt="Imagen del Producto" loading="lazy">
    </picture>
  </div>
  <div class="producto-detalles">
    <h2 class="producto-nombre"><?php echo $producto->nombre ?></h2>
    <p class="producto-descripcion"> <?php echo $producto->descripcion_larga ?></p>
    <p class="producto-precio">Precio: <?php echo $producto->precio ?></p>
    <p class="producto-marca"><?php echo $producto->marca_nombre?></p>
    <p class="producto-categoria"><?php echo $producto->categoria_nombre ?></p>
    <p class="producto-disponibilidad"><?php echo $producto->disponible ? "Disponible" : "No Disponible" ?></p>
  </div>
  <button onclick="history.back()" class="button button-secondary section-button">Volver</button>
</section>

