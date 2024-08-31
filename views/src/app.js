window.addEventListener("DOMContentLoaded", iniciarApp);

/**
 * Inicializa los eventos de filtrado para el formulario de productos.
 * Este script se envía automáticamente en el formulario cuando se cambia un select
 */
function iniciarApp() {
  filtroDeProductos()
  animarLandingPage()
  animarProductos()
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
       * Añade la clase 'changed' al select cuando cambia
       */
      select.classList.add('changed');
      
      /**
       * Remueve la clase 'changed' después de 3 segundos
       */
      setTimeout(() => {
        select.classList.remove('changed');
      }, 3000);
      /**
      * Envía el formulario cuando se cambia un select.
      */
      document.getElementById("filters-form").submit()
    });
  });
}

function animarLandingPage() {
    /**
   * Implementa una técnica de debounce para optimizar la ejecución de funciones
   * que se disparan frecuentemente.
   * 
   * @param {Function} func - La función a la que se aplicará el debounce.
   * @param {number} [wait=20] - El número de milisegundos a esperar antes de ejecutar la función.
   * @param {boolean} [immediate=true] - Si es true, la función se ejecuta al inicio en lugar del final.
   * @returns {Function} Una nueva función que implementa el comportamiento de debounce.
   */
  function debounce(func, wait = 20, immediate = true) {
    var timeout;
    return function() {
        var context = this, args = arguments;
        var later = function() {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        var callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
  }

  /**
  * Selecciona todos los elementos que tienen clases de animación.
  * 
  * @type {NodeListOf<Element>}
  */
  const animatedElements = document.querySelectorAll('.fade-in, .slide-in-left, .slide-in-right, .scale-in');

  /**
  * Verifica si los elementos animados están en el viewport y activa sus animaciones.
  * Esta función se llama durante el scroll y al cargar la página.
  */
  function checkAnimation() {
    animatedElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementBottom = element.getBoundingClientRect().bottom;
        
        /**
         * Determina si el elemento es visible en el viewport.
         * Se considera visible si su parte superior está dentro de los 100px
         * inferiores del viewport y su parte inferior está por encima del borde superior.
         */
        const isVisible = (elementTop < window.innerHeight - 100) && (elementBottom >= 0);
        
        if (isVisible) {
            element.classList.add('appear');
        }
    });
  }

  // Agrega un event listener para el evento de scroll, utilizando debounce para optimizar el rendimiento
  window.addEventListener('scroll', debounce(checkAnimation));

  // Agrega un event listener para el evento de carga de la página, para animar los elementos inicialmente visibles
  window.addEventListener('load', checkAnimation);
}

/**
 * Aplica animaciones a los productos y maneja interacciones
 */
function animarProductos() {
  const productos = document.querySelectorAll('.producto-card');
  
  /**
   * Aplica animación de entrada con retraso a cada producto
   */
  productos.forEach((producto, index) => {
    producto.style.animationDelay = `${index * 0.1}s`;
  });

  /**
   * Aplica animación de fadeIn al grid de productos cuando cambia la página
   */
  const productosGrid = document.querySelector('.productos-grid');
  if (productosGrid) {
    productosGrid.style.animation = 'fadeIn 0.5s ease';
  }

  /**
   * Mejora la interactividad de los botones de paginación
   */
  const paginationLinks = document.querySelectorAll('.pagination a');
  paginationLinks.forEach(link => {
    link.addEventListener('mouseenter', () => {
      link.style.backgroundColor = '#00bcd4';
      link.style.color = 'white';
    });
    link.addEventListener('mouseleave', () => {
      link.style.backgroundColor = '';
      link.style.color = '';
    });
  });
}




