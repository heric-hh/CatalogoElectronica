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
        h1 {
          margin: 0;
          padding: 0;
        }
        nav {
          background-color: var(--navbar-background-color);
          border-radius: 1rem;
          padding: var(--spacing-sm) var(--spacing-lg);
          display: flex;
          align-items: center;
          margin-bottom: var(--spacing-sm);
          gap: 2rem;
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
          display: none;
        }

        div.button-wrapper {
          padding: var(--spacing-sm);
          border: 1px solid var(--color-primary);
          border-radius: var(--border-radius-buttons);
          display: flex;
          align-items: center;
          justify-content: center;
          cursor: pointer;

          button {
            border: none;
            cursor: pointer;
            background-color: transparent;
          }
        }

        .button-wrapper.active {
          background-color: var(--color-primary);
        }

        .submenu-wrapper {
          position: fixed;
          width: 63%;
          display: flex;
          justify-content: center;
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
          transform: translateY(-20px);
          transition: transform 0.3s ease;
        }
        .submenu-wrapper.active .submenu {
          transform: translateY(0);
        }
        .submenu-link {
          font-weight: 300;
          padding: var(--spacing-sm) var(--spacing-lg);
        }

        .submenu-link:hover {
          color: silver;
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
      <nav class="submenu-wrapper">
        <div class="submenu">
          <a class="submenu-link" href="#">Productos</a>
          <a href="#" class="submenu-link">Contacto</a>
          <a href="#" class="submenu-link">Nosotros</a>
        </div>
      </nav>
    `
  }

  addEventListeners() {
    const menuButton = this.shadowRoot.querySelector(".button-wrapper")
    const subMenu = this.shadowRoot.querySelector(".submenu-wrapper")

    menuButton.addEventListener("click", (e) => {
      e.stopPropagation() // Previene que el clic en el botón cierre inmediatamente el menú
      this.toggleMenu()
    })

    // Añadir evento de clic al documento
    document.addEventListener("click", (e) => {
      const isClickInsideMenu = subMenu.contains(e.target)
      const isClickOnButton = menuButton.contains(e.target)

      if (!isClickInsideMenu && !isClickOnButton && subMenu.classList.contains("active")) {
        this.toggleMenu()
      }
    })}
    
    toggleMenu() {
      const menuButton = this.shadowRoot.querySelector(".button-wrapper")
      const subMenu = this.shadowRoot.querySelector(".submenu-wrapper")
      subMenu.classList.toggle("active")
      menuButton.classList.toggle("active")
    }
}
customElements.define("nav-bar", NavBar)
