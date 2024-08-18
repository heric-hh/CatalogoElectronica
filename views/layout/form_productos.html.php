<div class="label-input-wrapper">
  <label for="nombre" class="label">Nombre del Producto</label>
  <input type="hidden" name="producto[id]" value="<?php echo sanitize($producto->id); ?>" />
  <input type="text" class="input" placeholder="Ingresa el nombre del producto" name="producto[nombre]" id="nombre" value="<?php echo sanitize($producto->nombre) ?? ""?>">
</div>
<div class="label-input-wrapper">
  <label for="imagen" class="label">Imagen del Producto</label>
  <input type="file" id="imagen" accept="image/jpeg, image/png" name="producto[imagen]">
</div>
<div class="label-input-wrapper">
  <label for="descripcion_larga" class="label">Descripción Larga del Producto</label>
  <textarea name="producto[descripcion_larga]" id="descripcion_larga"> <?php echo sanitize($producto->descripcion_larga)?></textarea>
</div>
<div class="label-input-wrapper">
  <label for="descripcion_corta" class="label">Descripción Corta del Producto</label>
  <input type="text" name="producto[descripcion_corta]" id="descripcion_corta" class="input" placeholder="Interfaz de audio, guitarra, etc" value="<?php echo sanitize($producto->descripcion_corta)?>">
</div>
<div class="label-input-wrapper">
  <label for="categoria" class="label">Categoría del producto</label>
  <select name="producto[id_categoria]" id="categoria">
    <option value="">Seleccionar</option>
    <?php foreach($categorias as $categoria) : ?>
        <option value="<?php echo $categoria->id; ?>" <?php echo $producto->id_categoria == $categoria->id ? 'selected' : ''; ?>>
            <?php echo $categoria->categoria; ?>
        </option>
    <?php endforeach; ?>
</select>
</div>
<div class="label-input-wrapper">
  <label for="marca" class="label">Marca del Producto</label>
  <select name="producto[id_marca]" id="marca">
    <option value="">Seleccionar</option>
    <?php foreach($marcas as $marca) : ?>
        <option value="<?php echo $marca->id; ?>" <?php echo $producto->id_marca == $marca->id ? 'selected' : ''; ?>>
          <?php echo $marca->marca; ?>
        </option>
    <?php endforeach; ?>
</select>
</div>
<div class="label-input-wrapper">
  <label for="precio" class="label">Precio del Producto</label>
  <input type="number" class="input" placeholder="$200.00" name="producto[precio]" value="<?php echo sanitize($producto->precio)?>">
</div>
<div class="label-input-wrapper">
  <label for="disponible" class="label">Disponible</label>
  <select name="producto[disponible]" id="disponible">
    <option value="">Seleccionar</option>
    <option value="1" <?php echo $producto->disponible ? 'selected' : ''; ?>>Disponible</option>
    <option value="0" <?php echo !$producto->disponible ? 'selected' : ''; ?>>No disponible</option>
  </select>
</div>