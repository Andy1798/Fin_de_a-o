<?php require_once 'includes/head.php' ?>
<link rel="stylesheet" href="/static/css/user_page/home_page.css">
</head>
<body>
<?php require_once 'includes/header.php' ?>

<div id="scrollToTopBtn" title="Volver arriba">
    <i class="fas fa-arrow-up arrow"></i>
    <img src="/static/img/auto.png" alt="Coche para subir" class="car-image">
</div>



    <!-- Slider de imágenes -->
    <div class="swiper-container fade-in">
        <div class="swiper-wrapper">
            <?php foreach ($sliderImages as $image): ?>
                <div class="swiper-slide">
                    <img src="/<?= $image['image'] ?>" alt="Slider Image">
                    <?php if (!empty($image['caption'])): ?>
                        <div class="caption"><?= $image['caption'] ?></div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        
    </div>

    <!-- Botón de desplazamiento hacia abajo a la sección de marcas -->
    <div class="scroll-button" data-target="brands-section">&#x2193;</div>

    <!-- Sección de marcas -->
    <section class="brands-section fade-in" id="brands-section">
    <div class="container">
        <h2>Marcas con las que trabajamos</h2>
        <div class="brands-slider-container">
            <button class="slider-arrow prev">&#10094;</button>
            <div class="brands-slider">
                <div class="brands-track">
                    <div class="brand-logo"><img src="/static/img/marcas/moura.png" alt="Marca 1"></div>
                    <div class="brand-logo"><img src="/static/img/marcas/shell.png" alt="Marca 2"></div>
                    <div class="brand-logo"><img src="/static/img/marcas/monroe.svg" alt="Marca 3"></div>
                    <div class="brand-logo"><img src="/static/img/marcas/nakata.jpg" alt="Marca 4"></div>
                    <div class="brand-logo"><img src="/static/img/marcas/gmb.png" alt="Marca 5"></div>
                    <div class="brand-logo"><img src="/static/img/marcas/sachs.png" alt="Marca 6"></div>
                    <div class="brand-logo"><img src="/static/img/marcas/mann.webp" alt="Marca 7"></div>
                    <div class="brand-logo"><img src="/static/img/marcas/ngk.png" alt="Marca 8"></div>
                    <div class="brand-logo"><img src="/static/img/marcas/gates.svg" alt="Marca 9"></div>


                </div>
            </div>
            <button class="slider-arrow next">&#10095;</button>
        </div>
    </div>
</section>


    <!-- Slider de Productos Destacados -->
    <section class="productos-destacados fade-in" id="productos-destacados">
        <h2>Productos en Tendencia</h2>
        <div class="productos-container">
            <button class="btn-anterior">&#10094;</button>
            <div class="productos-wrapper">
                <div class="productos-slider">
                    <?php foreach ($featuredProducts as $product): ?>
                        <div class="producto fade-in-producto">
                            <div class="producto-imagen">
                                <img src="/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                                <div class="overlay">
                                    <a class="btn-add-cart" href="/catalog/product/<?= htmlspecialchars($product['id']) ?>">Ver Opciones</a>
                                </div>
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

    <!-- Sección de categorías -->
    <section class="category-section fade-in">
    <h2>Categorías del Catálogo</h2>
    <div class="categories-wrapper">
        <a href="/catalog/category/1" class="category-box" style="background-image: url('/static/img/img_features/P-10.jpg');">
            <span class="category-title">Aceites</span>
        </a>
        <a href="/catalog/category/2" class="category-box" style="background-image: url('/static/img/img_features/P-10.jpg');">
            <span class="category-title">Repuestos</span>
        </a>
        <a href="/catalog/category/3" class="category-box" style="background-image: url('/static/img/img_features/P-10.jpg');">
            <span class="category-title">Lubricantes</span>
        </a>
        <a href="/catalog/category/4" class="category-box" style="background-image: url('/static/img/img_features/P-10.jpg');">
            <span class="category-title">Filtros</span>
        </a>
        <a href="/catalog/category/5" class="category-box" style="background-image: url('/static/img/img_features/P-10.jpg');">
            <span class="category-title">Baterías</span>
        </a>
        <a href="/catalog/category/6" class="category-box" style="background-image: url('/static/img/img_features/P-10.jpg');">
            <span class="category-title">Neumáticos</span>
        </a>
    </div>
</section>


    <!-- Sección de contacto -->
    <section class="contact-info fade-in">
        <a href="https://wa.me/59894547958?text=Hola%2C%20tengo%20una%20en%20consulta%20" target="_blank">
            <img src="/static/img/img_wpp.png" alt="Comuníquese con nosotros" class="contact-image"> 
        </a>
    </section>
    <?php require_once 'includes/foot.php' ?>
    
  
    
    <script src="/static/js/user_page/home_page.js"></script>
    <?php require_once 'includes/footer.php' ?>

</html>
