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
        <div class="lista-wrapper">
        <ul class="dashboard-lista">
          <?php foreach ($categoriasMasVistas as $index => $categoria): ?>
            <li class="dashboard-item <?php echo $index < 3 ? ['gold', 'silver', 'bronze'][$index] : 'other'; ?>">
                <span class="dashboard-medalla">
                    <?php echo $index < 3 ? ['🥇', '🥈', '🥉'][$index] : '🏅'; ?>
                </span>
                <span class="lista-nombre"><?php echo htmlspecialchars($categoria->categoria); ?></span>
                <span class="lista-vistas">(<?php echo number_format($categoria->total_consultas); ?> visitas)</span>
            </li>
          <?php endforeach; ?>
        </ul>
        </div>
    </div>
    <div class="box">
        <h2>Marcas Más Visitadas</h2>
        <div class="lista-wrapper">
        <ul class="dashboard-lista">
          <?php foreach ($marcasMasVistas as $index => $marca): ?>
            <li class="dashboard-item <?php echo $index < 3 ? ['gold', 'silver', 'bronze'][$index] : 'other'; ?>">
                <span class="dashboard-medalla">
                    <?php echo $index < 3 ? ['🥇', '🥈', '🥉'][$index] : '🏅'; ?>
                </span>
                <span class="lista-nombre"><?php echo htmlspecialchars($marca->marca); ?></span>
                <span class="lista-vistas">(<?php echo number_format($marca->total_consultas); ?> visitas)</span>
            </li>
          <?php endforeach; ?>
        </ul>
        </div>
    </div>
</div>
<div class="column column-3">
    <div class="box">
        <h2>Productos Más Visitados</h2>
        <div class="lista-wrapper">
        <ul class="dashboard-lista">
          <?php foreach ($productosMasVistos as $index => $producto): ?>
            <li class="dashboard-item <?php echo $index < 3 ? ['gold', 'silver', 'bronze'][$index] : 'other'; ?>">
                <span class="dashboard-medalla">
                    <?php echo $index < 3 ? ['🥇', '🥈', '🥉'][$index] : '🏅'; ?>
                </span>
                <span class="lista-nombre"><?php echo htmlspecialchars($producto->nombre); ?></span>
                <span class="lista-vistas">(<?php echo number_format($producto->veces_consultado); ?> visitas)</span>
            </li>
          <?php endforeach; ?>
        </ul>
        </div>
    </div>
</div>
</div>

</section>