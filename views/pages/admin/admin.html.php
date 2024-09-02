<section class="section">
<?php 
  if($resultado) {
    $mensaje = mostrarMensajes(intval($resultado));
    if($mensaje) { ?>
      <p class="alerta exito"><?php echo $mensaje ?></p>
    <?php }
  }
?>
<div class="grid-estadisticas">
  <div class="column column-1">
    <div class="box">
        <h2>Producto Más Visto</h2>
        <div class="detalles-producto">
          <div class="pmv-img-wrapper">
            <img src="<?php echo IMAGENES_DIR . $productoMasVisto->imagen?>.webp" alt="producto_mas_visto">
          </div>
          <div class="pmv-detalles">
            <p><?php echo $productoMasVisto->nombre?></p>
            <p>$ <?php echo $productoMasVisto->precio?></p>
            <p class="vistas">Vistas: <?php echo $productoMasVisto->total_consultas ?></p>
          </div>
        </div>
    </div>
    <div class="box">
        <h2>Producto Más Solicitado</h2>
        <p>Este es el segundo contenedor de la columna 1.</p>
    </div>
</div>
<div class="column column-2">
    <div class="box">
        <h2>Categorías Mas Visitadas</h2>
        <p>Este es el primer contenedor de la columna 2.</p>
    </div>
    <div class="box">
        <h2>Marcas Más Visitadas</h2>
        <p>Este es el segundo contenedor de la columna 2.</p>
    </div>
</div>
<div class="column column-3">
    <div class="box">
        <h2>Productos Más Visitados</h2>
        <p>Este es el único contenedor de la columna 3, que ocupa todo el espacio vertical.</p>
    </div>
</div>
</div>

</section>