window.addEventListener("DOMContentLoaded", iniciarApp);

/**
 * Inicializa los eventos de filtrado para el formulario de productos.
 * Este script se envía automáticamente en el formulario cuando se cambia un select
 */
function iniciarApp() {
  filtroDeProductos()    
}

function filtroDeProductos() {
  /**
   * Selecciona todos los elementos select dentro del formulario de filtro.
   * @type {NodeListOf<HTMLSelectElement>}
   */
  const selects = document.querySelectorAll(".filter-select");
  
  /**
   * Agrega un event listener de cambio a cada select.
   */
  selects.forEach(select => {
    select.addEventListener("change", () => {
      /**
      * Envía el formulario cuando se cambia un select.
      */
      document.getElementById("filters-form").submit()
    });
  });
}
