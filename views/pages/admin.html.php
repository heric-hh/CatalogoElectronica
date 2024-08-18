<section class="section">
<?php 
  if($resultado) {
    $mensaje = mostrarMensajes(intval($resultado));
    if($mensaje) { ?>
      <p class="alerta exito"><?php echo sanitize($mensaje) ?></p>
    <?php }
  }
?>

</section>