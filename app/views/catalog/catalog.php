<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/user_page/header.css">
    <link rel="stylesheet" href="/static/css/user_page/catalog.css">
    <link rel="stylesheet" href="/static/css/user_page/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title><?= $title ?></title>
    <link rel="icon" href="/static/img/rutamt.ico" type="image/x-icon">

</head>

<body>

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
                    <li><a href="/catalog" class="header-nav-link"><i class="fa-solid fa-book"></i>&nbsp;CATÁLOGO</a>
                    </li>
                    <?php if (isset($_SESSION["userLogged"])): ?>
                        <li><a href="/user/orders" class="header-nav-link"><i class="fa-solid fa-book"></i>&nbsp;MIS
                                ORDENES</a>
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


    <div class="full-width-div">
        <!-- Botón de Filtrar -->
        <button class="filter-button" onclick="toggleOffcanvas()">
            <i class="fas fa-filter filter-icon"></i>Filtrar
        </button>

        <div class="sort-container">
            <button class="sort-button" onclick="toggleMenu()">Ordenar: Precio <span
                    class="arrow">&#9662;</span></button>
            <div class="sort-menu" id="sortMenu">
                <a href="?<?php echo http_build_query(array_merge($_GET, ['order' => 'menor'])); ?>">Menor precio</a>
                <a href="?<?php echo http_build_query(array_merge($_GET, ['order' => 'mayor'])); ?>">Mayor precio</a>
            </div>
        </div>

        <div class="offcanvas-menu" id="offcanvasMenu">
            <div class="offcanvas-content">
                <h2>CATEGORÍAS</h2>
                <button class="offcanvas-close" onclick="toggleOffcanvas()">✖</button>
                <ul>
                    <?php foreach ($categories as $category): ?>
                        <li><a href="/catalog/category/<?= $category['id'] ?>">
                                <?= $category['name'] ?>
                            </a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>


    </div>

    <div class="content">
        <!-- Sidebar with categories -->
        <aside class="sidebar">
            <h2>CATEGORIAS</h2>
            <ul>
                <?php foreach ($categories as $category): ?>
                    <li><a href="/catalog/category/<?= $category['id'] ?>">
                            <?= $category['name'] ?>
                        </a></li>
                <?php endforeach; ?>
            </ul>
        </aside>

        <!-- Main container encapsulating filter and catalog -->
        <div class="main-content">
            <!-- Dynamic product catalog -->
            <section class="catalog">
                <div class="products-grid">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="product" data-name="<?= htmlspecialchars(strtolower($product['name'])) ?>">
                                <div class="product-img-wrapper">
                                    <img src="/<?= htmlspecialchars($product['image']) ?>"
                                        alt="Imagen de <?= htmlspecialchars($product['name']) ?>" class="product-img" />
                                </div>
                                <div class="product-info">
                                    <h5 class="product-name">
                                        <?= htmlspecialchars($product['name']) ?>
                                        <?= htmlspecialchars($product['model']) ?>
                                        <?= htmlspecialchars($product['brand_name']) ?>
                                    </h5>
                                    <p class="product-price">$<?= htmlspecialchars($product['price']) ?></p>
                                    <a class="btn btn-cart" href="/catalog/product/<?= htmlspecialchars($product['id']) ?>">VER
                                        OPCIONES</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>NO HAY PRODUCTOS DISPONIBLES EN ESTE MOMENTO</p>
                    <?php endif; ?>
                </div>
            </section>
            <!-- Controles de Paginación -->
            <!-- Controles de Paginación -->
            <div class="pagination">
                <?php
                // Determinar las páginas visibles para la paginación
                $visiblePages = 3; // Número de páginas visibles (ajustable)
                $startPage = max(1, $currentPage - floor($visiblePages / 2));
                $endPage = min($totalPages, $startPage + $visiblePages - 1);
                $startPage = max(1, $endPage - $visiblePages + 1);
                ?>

                <!-- Enlace a la página anterior -->
                <?php if ($currentPage > 1): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $currentPage - 1])); ?>"
                        class="page-link">
                        Anterior
                    </a>
                <?php endif; ?>

                <!-- Enlaces a las páginas individuales -->
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>"
                        class="page-link <?= $i == $currentPage ? 'active' : '' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <!-- Enlace a la página siguiente -->
                <?php if ($currentPage < $totalPages): ?>
                    <a href="?<?php echo http_build_query(array_merge($_GET, ['page' => $currentPage + 1])); ?>"
                        class="page-link">
                        Siguiente
                    </a>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <?php require_once __DIR__ . '/../includes/foot.php'; ?>
    <script src="/static/js/user_page/catalog.js"></script>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>