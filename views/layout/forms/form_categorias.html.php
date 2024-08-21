<div class="label-input-wrapper">
  <label for="categoria" class="label">Nombre de la Categoría</label>
  <input type="text" class="input" placeholder="Ingresa el nombre de la categoría" name="categoria[categoria]" id="categoria" value="<?php echo $categoria->categoria?>" />
  <input type="hidden" name="categoria[id]" value="<?php echo $categoria->id; ?>" />
</div>