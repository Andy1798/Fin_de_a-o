<?php require_once __DIR__ . '/../includes/head.php'; ?>
<link rel="stylesheet" href="/static/css/user_page/product_view_catalog.css">
</head>
<body>
<?php require_once __DIR__ . '/../includes/header.php'; ?>

<!-- Botón de volver al listado -->
<a href="/catalog" class="btn-Back-product">
    <span class="icon-product">⟵</span>
    <span class="text-product">Volver al Catálogo</span>
</a>

<!-- Sección principal del producto -->
<div class="product-container">
    <!-- Sección de la imagen del producto -->
    <div class="product-image-section">
        <div class="product-main-image">
            <img src="/<?= $product['image'] ?>" alt="Imagen de <?= $product['name'] ?>" class="main-img">
        </div>
    </div>

    <!-- Línea vertical separadora -->
    <div class="vertical-divider"></div>

    <!-- Sección de información del producto -->
    <div class="product-info-section">
        <h1 class="product-title"><?= $product['name'] ?> <?= $product['model'] ?> <?= $product['brand_name'] ?></h1>
        <p class="product-price">$<?= $product['price'] ?></p>
        <p class="product-availability-product">Disponibilidad: <span><?= $product['quantity'] ?></span> productos</p>
        <p class="product-description"><?= $product['description'] ?></p>

        <hr class="product-divider">
        <form action="/cart/add/<?= $product['id'] ?>" method="POST" class="form-product">
        <div class="quantity-cart-container">
            <div class="quantity-controls">
                <button type="button" onclick="changeQuantity(-1, 'quantity')" class="btn-decrement">-</button>
                <input type="number" id="quantity" name="quantity" min="1" max="<?= $product['quantity'] ?>" value="1" required class="quantity-input">
                <button type="button" onclick="changeQuantity(1, 'quantity')" class="btn-increment">+</button>
            </div>

                <button type="submit" class="btn-add-to-cart" id="addToCartButton">
                    <i class="fas fa-shopping-cart"></i> Añadir al carrito
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Contenedor fijo para dispositivos móviles -->
<form action="/cart/add/<?= $product['id'] ?>" method="POST" class="form-product">

<div class="fixed-mobile-cart">
    <div class="quantity-controls">
    <button type="button" onclick="changeQuantity(-1, 'quantity')" class="btn-increment">-</button>
        <input type="number" id="quantity-mobile" name="quantity" min="1" max="<?= $product['quantity'] ?>" value="1" required class="quantity-input">
        <button type="button" onclick="changeQuantity(1, 'quantity')" class="btn-increment">+</button>
    </div>
    <button type="submit" class="btn-add-to-cart">
        <i class="fas fa-shopping-cart"></i> Añadir al carrito
    </button>
</div>
</form>
<?php if (!empty($similarProducts)): ?>
    <section class="productos-destacados fade-in" id="productos-destacados">
        <h2>Productos en Tendencia</h2>
        <div class="productos-container">
            <button class="btn-anterior">&#10094;</button>
            <div class="productos-wrapper">
                <div class="productos-slider">
                    <?php foreach ($similarProducts as $product): ?>
                        <div class="producto fade-in-producto">
                            <div class="producto-imagen">
                                <img src="/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                                <div class="overlay">
                                <a class="btn-add-cart" href="/catalog/product/<?= htmlspecialchars($product['id']) ?>">Ver Opciones</a>                                </div>
                            </div>
                            <div class="producto-info">
                                <h3 class="producto-nombre"><?= $product['name'] ?></h3>
                                <span class="producto-precio">$<?= $product['price'] ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <button class="btn-siguiente">&#10095;</button>
        </div>
    </section>
<?php endif; ?>

<hr class="product-divider">

<?php require_once __DIR__ . '/../includes/foot.php'; ?>
    <script src="/static/js/user_page/product_view_catalog.js"></script>   
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
    </body>
</html>
