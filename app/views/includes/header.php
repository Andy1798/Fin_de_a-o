<header id="header">
    <div class="wrapper">

        <nav>
            <input type="checkbox" id="show-search">
            <input type="checkbox" id="show-menu">
            <label for="show-menu" id="menu-icon" class="menu-icon "><i class="fas fa-bars"></i></label>
            <div id="logo" class="logo"><a href="/"><img src="/static/img/rutamt.png" alt=""></a></div>
            <div id="container">
                <div id="search-container" class="search-container ">
                    <input type="text" placeholder="Buscar Productos..." class="search-input">
                    <button class="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <button id="toggle-search" type="button" class="drop">
    <i id="icon-open" class="fas fa-search visible"></i>
    <i id="icon-close" class="fas fa-close"></i>
</button>
            </div>
            <div class="content-header">
                <ul class="links">
                <li><a href="/"><i class="fa-solid fa-house"></i>&nbsp;INICIO</a></li>
                    <li><a href="/catalog"><i class="fa-solid fa-book"></i>&nbsp;CATÁLOGO</a></li>
                    <li><a href="/orderUser"><i class="fa-solid fa-book"></i>&nbsp;MIS ORDENES</a></li>
                    <li class="login user-menu-container"> 
                        <?php if (isset($_SESSION["userLogged"])): ?>
                            <a href="#" class="user-menu">
                                <i class="fa-solid fa-user"></i>&nbsp;
                                <?php echo $_SESSION["userLogged"]["name"] . " " . $_SESSION["userLogged"]["lastname"]; ?>
                            </a>
                            <ul class="submenu">
                                <li><a href="/user/logout">CERRAR SESION</a></li>
                            </ul>
                        <?php else: ?>
                            <a href="/user/login"><i class="fa-solid fa-user"></i>&nbsp;INICIAR SESION</a>
                        <?php endif; ?>
                    </li>


                    <li><a href="/cart"><i class="fa-solid fa-cart-shopping"></i>&nbsp; <span
                                id="cart-count">0</span></a></li>
                </ul>
            </div>

        </nav>
    </div>
</header>
