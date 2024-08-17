<section class="section">
  <h2 class="title">¡Bienvenido!</h2>
  <p class="subtitle">Administra toda la información de tus productos ingresando al sitio.</p>
  <?php foreach ($errores as $error) : ?>
  <div class="alerta error">
    <?php echo $error?>
  </div>
  <?php endforeach ?>
  <form class="login-wrapper" method="post">
    <div class="label-input-wrapper">
      <label for="usuario" class="label-login">Usuario</label>
      <input type="text" placeholder="Ingresa tu usuario" class="input input-login" id="usuario" name="usuario"/>
    </div>
    <div class="label-input-wrapper">
      <label for="contrasena" class="label-login">Contraseña</label>
      <input type="password" placeholder="Ingresa tu contraseña" class="input input-login" id="contrasena" name="contrasena"/>
    </div>
    <input type="submit" value="Ingresar" class="button button-primary">
  </form>
</section>