/**
 * @class Navbar
 * @extends HTMLElement
 * @description Componente de barra de navegación personalizada con funcionalidad de busqueda en vivo
 */

class NavBar extends HTMLElement {
  /**
   * @constructor
   * @description Inicializa el componente NavBar, configura el shadow DOM y los event listeners.
   */

  constructor() {
    super()
    this.attachShadow({mode: "open"})
    this.render()
    this.addEventListeners()
    this.checkScreenSize()
    window.addEventListener("resize", () => {
      this.checkScreenSize()
      this.adjustSubmenuPosition()
      if(window.innerWidth < 1200) {
        this.shadowRoot.querySelector(".search-wrapper").classList.remove("active")
      }
    })
  }

  /**
   * @method render
   * @description Renderiza el HTML y CSS del componente en el shadow DOM.
   */

  render() {
    this.shadowRoot.innerHTML = `
      <style>
        /* Globales */
        :host {
          display: block;
          position: relative;
        }
        h1 {
          margin: 0;
          padding: 0;
          line-height: 2rem;
        }
        nav {
          background-color: var(--navbar-background-color);
          border-radius: 1rem;
          padding: var(--spacing-sm) var(--spacing-md);
          display: flex;
          margin-bottom: var(--spacing-sm);
          gap: 3rem;
          justify-content: space-between;
          align-items: center;
        }

        a {
          text-decoration: none;
          text-align: center;
          margin: 0;
          padding: 0;
          font-size: var(--font-size-medium);
          font-weight: 500;
          color: var(--color-primary-text);
        }

        ul {
          list-style: none;
          padding: 0;
          margin: 0;
        }

        input {
          border-radius: var(--border-radius-inputs);
          background: var(--navbar-background-color);
          color: var(--color-primary-text);
          font-weight: 300;
          padding: var(--spacing-sm) var(--spacing-md);
          border: 1px solid var(--color-primary-text);
        }

        .navlink-lg {
          display: none;
        }
        
        /*Media querys*/
        /*Desktop*/
        @media (min-width: 1200px) {
          .navlink-lg {
            display: flex;
            gap: 2rem;
            align-items: center;
          }
          .navlink-lg a {
            font-weight: 300;
            font-size: var(--font-size-sm);
          }

          .button-wrapper img.burger-icon {
            display: none;
          }
          
          .button-wrapper img#search-icon {
            display: block;
          }
  
          .submenu-wrapper {
            display: none !important;
          }
        }

        /* Boton para abrir menu */
        .button-wrapper {
          padding: 5px;
          border-radius: var(--border-radius-buttons);
          cursor: pointer;
          display: block;
        }

        .button-wrapper button {
          border: none;
          cursor: pointer;
          background-color: transparent;
        }
        
        /*Estilos base para iconos */
        .button-wrapper img {
          display: none;
        }

        //Mostrar icono de hamburgesa por defecto (movil)
        .button-wrapper img.burger-icon {
          display: block;
        }

        /* Mostrar icono de hamburguesa por defecto (móvil y tablet) */
        .button-wrapper img.burger-icon {
          display: block;
        }

        .button-wrapper.active {
          background-color: var(--color-primary);
        }
        
        /* Barra de Navegación para mobile*/
        .submenu-wrapper {
          position: absolute;
          top: 100%;
          left: 0;
          right: 0;
          background-color: var(--navbar-background-color);
          border-radius: 1rem;
          z-index: 2;
          opacity: 0;
          visibility: hidden;
          transition: opacity 0.3s ease, visibility 0.3s ease;
        }
        .submenu-wrapper.active {
          opacity: 1;
          visibility: visible;
        }
        .submenu {
          display: flex;
          flex-direction: column;
          gap: var(--spacing-sm);
          padding: var(--spacing-sm) var(--spacing-md);
        }
        .submenu-link {
          display: block;
          font-weight: 300;
          padding: var(--spacing-sm) var(--spacing-lg);
        }

        .submenu-link:hover {
          color: silver;
        }

        .submenu-input {
          width: 100%;
          box-sizing: border-box;
        }

        /*Submenu de búsqueda*/
        .search-wrapper {
          display: none;
          position: absolute;
          top: 100%;
          left: 0;
          right: 0;
          background-color: var(--navbar-background-color);
          padding: var(--spacing-md);
          border-radius: 0 0 1rem 1rem;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .search-wrapper.active {
          display: flex;
          justify-content: space-around;
        }

        .search-wrapper input {
          width: 70%;
          border: 1px solid var(--color-primary-text);
          border-radius: var(--border-radius-inputs);
        }

        .search-wrapper input[type="submit"] {
          border: none;
          background-color: var(--color-primary);
          width: 20%;
          cursor: pointer;
          font-weight: 500;
          border-radius: var(--border-radius-buttons);
          letter-spacing: 0.6px;
          transition: background-color 0.3s;
        }
        
        .search-wrapper input[type="submit"]:hover {
          background-color: darken(var(--color-secondary), 10%);
        }

        /* Estilos para los resultados de busqueda en vivo */
        .live-search-results {
          position: absolute;
          top: 100%;
          left: 0;
          right: 0;
          background-color: var(--navbar-background-color);
          border-radius: var(--border-radius-inputs);
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          z-index: 3;
          max-height: 300px;
          overflow-y: auto;
          display: none;
        }

        .live-search-results {
          display: none;
        }

        .live-search-results.active {
          display: block;
          margin: var(--spacing-sm) 0;
        }

        .live-search-item {
          padding: var(--spacing-sm) var(--spacing-md);
          cursor: pointer;
          display: flex;
          align-items: center;
          padding: 5px;
        }

        .live-search-item:hover {
          background-color: rgba(255, 255, 255, 0.1);
        }

        .product-thumbnail {
          width: 50px;
          height: 50px;
          object-fit: cover;
          margin-right: 10px;
          border-radius: 10px;
        }

      </style>

      <nav>
        <h1>
          <a href="/" >Electrónica El Control</a>
        </h1>
        <ul class="navlink-lg">
          <li> <a href="/productos">Productos</a> </li>
          <li> <a href="#contacto">Contacto</a> </li>
          <li> <a href="/nosotros">Nosotros</a> </li>
        </ul>
        <div class="button-wrapper">
          <button aria-label="Abrir Menú">
            <img src="/views/assets/img/burger.svg" alt="menu" class="burger-icon" />
            <img src="/views/assets/img/search.png" alt="search" id="search-icon" />
          </button>
        </div>
      </nav>
      <div class="submenu-wrapper">
        <div class="submenu">
          <a class="submenu-link" href="/productos">Productos</a>
          <a href="#contacto" class="submenu-link">Contacto</a>
          <a href="/nosotros" class="submenu-link">Nosotros</a>
          <input class="submenu-input input-search" type="text" placeholder="¿Qué estás buscando?" name="search"/>
          <div class="live-search-results"></div>
        </div>
      </div>
      <form class="search-wrapper">
        <input type="text" placeholder="¿Qué estás buscando?" aria-label="Buscar" />
        <input type="submit" value="Buscar" class="button">
        <div class="live-search-results"></div>
      </form>
    `
  }
  
  /**
   * @method addEventListeners
   * @description Agrega los event listeners necesarios para la funcionalidad del componente.
   */

  addEventListeners() {
    const menuButton = this.shadowRoot.querySelector(".button-wrapper")
    const subMenu = this.shadowRoot.querySelector(".submenu-wrapper")

    menuButton.addEventListener("click", (e) => {
      e.stopPropagation()
      this.toggleMenu()
    })

    subMenu.addEventListener("click", (e) => {
      e.stopPropagation()
    })

    document.addEventListener("click", (e) => {
      if (!this.contains(e.target) && subMenu.classList.contains("active")) {
        this.toggleMenu()
      }
    })

    //Listener para cambios de tamaño de pantalla
    window.addEventListener('resize', () => {
      this.adjustSubmenuPosition()
      this.checkScreenSize()
    })

    //Comprobar tamaño de pantalla inicial
    this.checkScreenSize()

    //Cerrar la pantalla de búsqueda cuando se haga clic fuera de ella
    document.addEventListener("click", (e) => {
      const searchWrapper = this.shadowRoot.querySelector(".search-wrapper")
      const button = this.shadowRoot.querySelector(".button-wrapper")
      if(window.innerWidth >= 1200 &&
        !this.contains(e.target) &&
        !button.contains(e.target) &&
        searchWrapper.classList.contains("active")
      ) {
        this.toggleSearchWrapper()
      }
    })

    const mobileSearchInput = this.shadowRoot.querySelector(".submenu-input")
    const desktopSearchInput = this.shadowRoot.querySelector(".search-wrapper input[type='text']")

    mobileSearchInput.addEventListener("input", (e) => this.handleLiveSearch(e, "mobile"))
    desktopSearchInput.addEventListener("input", (e) => this.handleLiveSearch(e, "desktop"))

    const searchForm = this.shadowRoot.querySelector(".search-wrapper")
    searchForm.addEventListener("submit", (e) => e.preventDefault())
  }

  /**
  * @method toggleMenu
  * @description Alterna la visibilidad del menú móvil o el wrapper de búsqueda en desktop.
  */

  toggleMenu() {
    if(window.innerWidth >= 1200) {
      this.toggleSearchWrapper()
    } else {
      const menuButton = this.shadowRoot.querySelector(".button-wrapper")
      const subMenu = this.shadowRoot.querySelector(".submenu-wrapper")
      subMenu.classList.toggle("active")
      menuButton.classList.toggle("active")
      this.adjustSubmenuPosition()
    }
  }

  /**
   * @method toggleSearchWrapper
   * @description Alterna la visibilidad del wrapper de búsqueda en pantallas grandes.
   */

  toggleSearchWrapper() {
    const searchWrapper = this.shadowRoot.querySelector(".search-wrapper")
    searchWrapper.classList.toggle("active")
    if(searchWrapper.classList.contains("active")) {
      searchWrapper.querySelector("input").focus()
    }
  }

  /**
   * @method adjustSubmenuPosition
   * @description Ajusta la posición del submenú de acuerdo al tamaño de la barra de navegación.
   */

  adjustSubmenuPosition() {
    const submenu = this.shadowRoot.querySelector('.submenu-wrapper')

    submenu.style.width = `${this.offsetWidth}px`
    submenu.style.left = '0px'
  }

  /**
   * @method checkScreenSize
   * @description Verifica el ancho de la pantalla y ajusta la interfaz en consecuencia.
   */
  
  checkScreenSize() {
    const submenu = this.shadowRoot.querySelector(".submenu-wrapper")
    const menuButton = this.shadowRoot.querySelector(".button-wrapper")
    const burgerIcon = this.shadowRoot.querySelector(".burger-icon")
    const searchIcon = this.shadowRoot.querySelector("#search-icon")
    const button = menuButton.querySelector("button")
    const searchWrapper = this.shadowRoot.querySelector(".search-wrapper")

    if(window.innerWidth >= 1200) {
      submenu.classList.remove("active")
      menuButton.classList.remove("active")
      burgerIcon.style.display = "none"
      searchIcon.style.display = "block"
      button.setAttribute("aria-label", "Buscar")
    } else {
      burgerIcon.style.display = "block"
      searchIcon.style.display = "none"
      button.setAttribute("aria-label", "Abrir Menú")
      searchWrapper.classList.remove("active")
    }
  }

  /**
   * @method handleLiveSearch
   * @param {Event} e - El evento de input.
   * @param {string} device - El dispositivo actual ('mobile' o 'desktop').
   * @description Maneja la búsqueda en vivo a medida que el usuario escribe.
   */

  async handleLiveSearch(e, device) {
    const searchTerm = e.target.value.trim()
    const resultsContainer = this.shadowRoot.querySelector(device === "mobile" ?
      ".submenu .live-search-results" : 
      ".search-wrapper .live-search-results")
    
    if(searchTerm.length < 2) {
      resultsContainer.innerHTML = ""
      resultsContainer.classList.remove("active")
      return
    }

    try {
      const results = await this.fetchSearchResults(searchTerm)
      resultsContainer.innerHTML = ""
      if(results.length > 0) {
        results.forEach(result => {
          const div = document.createElement("div")
          div.classList.add("live-search-item")
          
          div.innerHTML = `
            <img src="/views/assets/img_productos/${result.imagen}.webp" alt="${result.nombre}" class="product-thumbnail">
            <span>${result.nombre}</span>
          `

          div.addEventListener("click", () => this.handleResultClick(result))
          resultsContainer.appendChild(div)
        })
        resultsContainer.classList.add("active")
      } else {
        resultsContainer.classList.remove("active")
      }
      
      // Forzar un repintado del DOM
      resultsContainer.style.display = 'none'
      resultsContainer.offsetHeight // Leer una propiedad para forzar un reflow
      resultsContainer.style.display = ''
    } catch (error) {
      console.error("Error en la busqueda: ", error)
    }
  }

  /**
   * @method fetchSearchResults
   * @param {string} searchTerm - El término de búsqueda.
   * @returns {Promise<Array>} Una promesa que resuelve a un array de resultados de búsqueda.
   * @description Simula una llamada a la API para obtener resultados de búsqueda.
   */

  async fetchSearchResults(searchTerm) {
    try {
      const response = await fetch(`/api/productos?q=${encodeURIComponent(searchTerm)}`)
      
      if(!response.ok) {
        throw new Error("Error en la respuesta del servidor")
      }

      const data = await response.json()
      return data.productos
    } catch (error) {
      console.error("Error al buscar productos: ", error)
      return []
    }
  }

  /**
 * @method handleResultClick
 * @param {Object} result - El resultado de búsqueda seleccionado.
 * @param {number} result.id - El identificador único del producto.
 * @param {string} result.name - El nombre del producto.
 * @description Maneja el clic en un resultado de búsqueda.
 * @fires NavBar#productSelected
 */

  handleResultClick(result) {
    console.log("Producto seleccionado: ", result)

    //Disparar un evento personalizado con la información del producto seleccionado
    const event = new CustomEvent("productSelected", {
      detail: result,
      bubbles: true,
      composed: true
    })
    this.dispatchEvent(event)

    //Limpiar los resultados de busqueda
    const mobileResults = this.shadowRoot.querySelector(".submenu .live-search-results")
    const desktopResults = this.shadowRoot.querySelector(".search-wrapper .live-search-results")
    mobileResults.innerHTML = '';
    desktopResults.innerHTML = '';
    mobileResults.classList.remove('active');
    desktopResults.classList.remove('active');

    // Limpiar los campos de búsqueda
    this.shadowRoot.querySelector('.submenu-input').value = '';
    this.shadowRoot.querySelector('.search-wrapper input[type="text"]').value = '';
    // TODO: Implementar la navegación a la página del producto
    window.location.href = `/producto?id=${result.id}`;
  }
}

customElements.define("nav-bar", NavBar)
