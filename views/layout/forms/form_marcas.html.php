<div class="label-input-wrapper">
  <label for="marca" class="label">Nombre de la Marca</label>
  <input type="text" class="input" placeholder="Ingresa el nombre de la marca" name="marca[marca]" id="marca" value="<?php echo sanitize($marca->marca)?>" />
  <input type="hidden" name="marca[id]" value="<?php echo sanitize($marca->id); ?>" />
</div>