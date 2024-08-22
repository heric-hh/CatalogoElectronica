class NavBar extends HTMLElement {
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
        
        //Estilos base para iconos
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

      </style>

      <nav>
        <h1>
          <a href="/" >Electrónica El Control</a>
        </h1>
        <ul class="navlink-lg">
          <li> <a href="#">Productos</a> </li>
          <li> <a href="#contacto">Contacto</a> </li>
          <li> <a href="#">Nosotros</a> </li>
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
          <input class="submenu-input input-search" type="text" placeholder="¿Qué estás buscando?"/> 
        </div>
      </div>
      <form class="search-wrapper">
        <input type="text" placeholder="¿Qué estás buscando?" aria-label="Buscar" />
        <input type="submit" value="Buscar" class="button"
      </form>
    `
  }

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
  }
    
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

  //Mostrar el submenu de busqueda en pantallas mayores a 1200 px
  toggleSearchWrapper() {
    const searchWrapper = this.shadowRoot.querySelector(".search-wrapper")
    searchWrapper.classList.toggle("active")
    if(searchWrapper.classList.contains("active")) {
      searchWrapper.querySelector("input").focus()
    }
  }

  //Ajusta el submenu de acuerdo al tamaño de la barra de navegacion
  adjustSubmenuPosition() {
    const submenu = this.shadowRoot.querySelector('.submenu-wrapper')

    submenu.style.width = `${this.offsetWidth}px`
    submenu.style.left = '0px'
  }

  //Verifica el ancho de la pantalla para: -deshabilitar submenu movil
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
      burgerIcon.style.display = "block";
      searchIcon.style.display = "none";
      button.setAttribute("aria-label", "Abrir Menú");
      searchWrapper.classList.remove("active")
    }
  }
}

customElements.define("nav-bar", NavBar)
