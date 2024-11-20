<style>
    #loading-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }

    #loading-spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>

<header id="header">
    <div class="header-wrapper">
        <nav class="header-navigation">
            <button id="menu-button" class="header-menu-icon"><i class="fas fa-bars"></i></button>
            <div id="logo" class="header-logo">
                <a href="/" class="header-logo-link"><img src="/static/img/rutamt.png" alt="Logo"></a>
            </div>

            <div id="container" class="header-search-wrapper">
                <div id="search-container" class="header-search-container">
                    <input type="text" placeholder="Buscar Productos..." class="header-search-input">
                </div>
            </div>
            <button id="toggle-search" type="button" class="drop">
                <i id="icon-open" class="fas fa-search visible"></i>
                <i id="icon-close" class="fas fa-times"></i>
            </button>

            <ul class="header-links" id="menu-links">
                <li><a href="/" class="header-nav-link"><i class="fa-solid fa-house"></i>&nbsp;INICIO</a></li>
                <li><a href="/catalog" class="header-nav-link"><i class="fa-solid fa-book"></i>&nbsp;CATÁLOGO</a></li>
                <?php if (isset($_SESSION["userLogged"])): ?>
                    <li><a href="/user/orders" class="header-nav-link"><i class="fa-solid fa-book"></i>&nbsp;MIS ORDENES</a>
                    </li>
                <?php endif; ?>
                <li
                    class="header-login header-user-menu-container <?php echo isset($_SESSION['userLogged']) ? 'user-logged-in' : ''; ?>">
                    <?php if (isset($_SESSION['userLogged'])): ?>
                        <p class="header-user-menu">
                            <i class="fa-solid fa-user"></i>&nbsp;
                            <?php echo $_SESSION['userLogged']['name'] . " " . $_SESSION['userLogged']['lastname']; ?>
                        </p>
                        <ul class="header-submenu">
                            <li><a href="/user/logout" class="header-submenu-link">CERRAR SESION</a></li>
                        </ul>
                    <?php else: ?>
                        <a href="/user/login" class="header-nav-link"><i class="fa-solid fa-user"></i>&nbsp;INICIAR
                            SESION</a>
                    <?php endif; ?>
                </li>
                <li style="position: relative;"
                    class="header-cart-icon <?php echo isset($_SESSION['userLogged']) ? 'logged-in' : ''; ?>">
                    <a href="/cart" class="header-nav-link">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span id="cart-count" class="cart-count"></span>
                    </a>
                </li>

            </ul>
        </nav>

        <!-- Contenedor para mostrar resultados de búsqueda -->
        <div id="custom-resultados" class="header-resultados-busqueda"></div>
    </div>
</header>
