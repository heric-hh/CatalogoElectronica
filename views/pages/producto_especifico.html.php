<section class="section">
  <h3 class="title title-producto-especifico">Detalles del Producto</h3>
  <div class="flex-producto-especifico">
    <div class="img-container">
      <picture>
        <source srcset="<?php echo IMAGENES_DIR . $producto->imagen ?>.webp" type="image/webp">
        <img src="<?php echo IMAGENES_DIR . $producto->imagen ?>.webp" alt="Imagen del Producto" loading="lazy">
      </picture>
    </div>
    <div class="producto-detalles">
      <h2 class="producto-nombre"><?php echo $producto->nombre ?></h2>
      
      <span class="span-producto-especifico">Descripción</span>
      <p class="producto-descripcion"> <?php echo $producto->descripcion_larga ?></p>
  
      <span class="span-producto-especifico">Precio</span>
      <p class="producto-precio"><?php echo $producto->precio ?></p>
      
      <span class="span-producto-especifico">Marca</span>
      <p class="producto-marca"><?php echo $producto->marca_nombre?></p>
      
      <span class="span-producto-especifico">Categoría</span>
      <p class="producto-categoria"><?php echo $producto->categoria_nombre ?></p>
      
      <span class="span-producto-especifico">Disponibilidad</span>
      <p class="producto-disponibilidad"><?php echo $producto->disponible ? "Disponible" : "No Disponible" ?></p>
    </div>
  </div>
  <button onclick="history.back()" class="button button-secondary section-button">Volver</button>
</section>

