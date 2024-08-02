class NavBar extends HTMLElement {
  constructor() {
    super()
    this.attachShadow({mode: "open"})
    this.render()
    this.addEventListeners()
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
        }

        /* Boton para abrir menu */
        .button-wrapper {
          padding: 5px;
          border-radius: var(--border-radius-buttons);
          cursor: pointer;
        }

        .button-wrapper button {
          border: none;
          cursor: pointer;
          background-color: transparent;
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
      </style>

      <nav>
        <h1>
          <a href="/" >Electrónica El Control</a>
        </h1>
        <ul class="navlink-lg">
          <li> <a href="#">Productos</a> </li>
          <li> <a href="#">Contacto</a> </li>
          <li> <a href="#">Nosotros</a> </li>
        </ul>
        <div class="button-wrapper">
          <button>
            <img src="./views/assets/img/burger.svg" alt="menu" />
          </button>
        </div>
      </nav>
      <div class="submenu-wrapper">
        <div class="submenu">
          <a class="submenu-link" href="#">Productos</a>
          <a href="#" class="submenu-link">Contacto</a>
          <a href="#" class="submenu-link">Nosotros</a>
          <input class="submenu-input input-search" type="text" placeholder="¿Qué estás buscando?"/> 
        </div>
      </div>
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

    window.addEventListener('resize', () => {
      this.adjustSubmenuPosition()
    })
  }
    
  toggleMenu() {
    const menuButton = this.shadowRoot.querySelector(".button-wrapper")
    const subMenu = this.shadowRoot.querySelector(".submenu-wrapper")
    subMenu.classList.toggle("active")
    menuButton.classList.toggle("active")
    this.adjustSubmenuPosition()
  }

  adjustSubmenuPosition() {
    const submenu = this.shadowRoot.querySelector('.submenu-wrapper')
    
    submenu.style.width = `${this.offsetWidth}px`
    submenu.style.left = '0px'
  }
}

customElements.define("nav-bar", NavBar)
