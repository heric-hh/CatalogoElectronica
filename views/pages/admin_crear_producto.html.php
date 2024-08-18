<section class="section">
  <h3 class="title">Crear Producto</h3>
  <p class="subtitle">Crea un nuevo registro para un producto.</p>
  <?php foreach($errores as $error) : ?>
    <div class="alerta error">
      <?php echo $error ?>
    </div>
  <?php endforeach ?>
  <form action="/admin/productos/crear" method="post" class="form">
    <div class="label-input-wrapper">
      <label for="nombre" class="label">Nombre del Producto</label>
      <input type="text" class="input" placeholder="Ingresa el nombre del producto" name="producto[nombre]" id="nombre">
    </div>
    <div class="label-input-wrapper">
      <label for="imagen" class="label">Imagen del Producto</label>
      <input type="file" id="imagen" accept="image/jpeg, image/png" name="producto[imagen]">
    </div>
    <div class="label-input-wrapper">
      <label for="descripcion_larga" class="label">Descripción Larga del Producto</label>
      <textarea name="producto[descripcion_larga]" id="descripcion_larga"></textarea>
    </div>
    <div class="label-input-wrapper">
      <label for="descripcion_corta" class="label">Descripción Corta del Producto</label>
      <input type="text" name="producto[descripcion_corta]" id="descripcion_corta" class="input" placeholder="Interfaz de audio, guitarra, etc">
    </div>
    <div class="label-input-wrapper">
      <label for="categoria" class="label">Categoría del producto</label>
      <select name="producto[id_categoria]" id="categoria">
        <option value="">Seleccionar</option>
        <?php foreach($categorias as $categoria) : ?>
          <option value="<?php echo $categoria->id?>"><?php echo $categoria->categoria?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="label-input-wrapper">
      <label for="marca" class="label">Marca del Producto</label>
      <select name="producto[id_marca]" id="marca">
        <option value="">Seleccionar</option>
        <?php foreach($marcas as $marca) : ?>
          <option value="<?php echo $marca->id?>"><?php echo $marca->marca?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="label-input-wrapper">
      <label for="precio" class="label">Precio del Producto</label>
      <input type="number" class="input" placeholder="$200.00" name="producto[precio]">
    </div>
    <div class="label-input-wrapper">
      <label for="disponible" class="label">Disponible</label>
      <select name="producto[disponible]" id="disponible">
        <option value="">Seleccionar</option>
        <option value="true">Disponible</option>
        <option value="false">No disponible</option>
      </select>
    </div>
    <input type="submit" value="Guardar Producto" class="button button-primary">
  </form>
</section>