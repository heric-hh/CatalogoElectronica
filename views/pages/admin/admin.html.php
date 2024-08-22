<section class="section">
<?php 
  if($resultado) {
    $mensaje = mostrarMensajes(intval($resultado));
    if($mensaje) { ?>
      <p class="alerta exito"><?php echo $mensaje ?></p>
    <?php }
  }
?>

</section>