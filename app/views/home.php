<?php require_once 'includes/head.php' ?>
<?php require_once 'includes/header.php' ?>
<link rel="stylesheet" href="/static/css/user_page/home_page.css">

    <div class="swiper-container">
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

        <!-- Flechas de navegación -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

        <!-- Paginación -->
        <div class="swiper-pagination"></div>
    </div>



<!--Seccion de marcas -->
<section class="brands-section">
        <div class="container">
            <h2>Marcas con las que trabajamos</h2>
            <div class="brands-wrapper">
                <div class="brand-logo"><img src="/static/img/marcas/moura.png" alt="Marca 1"></div>
                <div class="brand-logo"><img src="/static/img/marcas/shell.png" alt="Marca 2"></div>
                <div class="brand-logo"><img src="/static/img/marcas/monroe.svg" alt="Marca 3"></div>
                <div class="brand-logo"><img src="/static/img/marcas/nakata.jpg" alt="Marca 4"></div>
                <div class="brand-logo"><img src="/static/img/marcas/gmb.png" alt="Marca 5"></div>

            </div>
        </div>
    </section>



    <br><br><br><br>


<!-- Slider de Productos Destacados -->
<section class="featured-products-section">
    <h2>Productos Destacados</h2>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="swiper-slide">
                    <div class="featured-product">
                        <img src="/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                        <div class="product-info">
                            <h3><?= $product['name'] ?></h3>
                            <p>Precio: $<?= $product['price'] ?></p>
                            <a href="/catalog/product/<?= $product['id'] ?>" class="btn">Ver Producto</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Flechas de navegación -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

        <!-- Paginación -->
        <div class="swiper-pagination"></div>
    </div>
</section>

       <!-- Categorías del catálogo -->

    <!-- Categorías del catálogo -->
    <section class="category-section">
        <h2>Categorías del Catálogo</h2>
        <div class="categories-wrapper">
            <div class="category-box">
                <a href="/catalog/category/1">
                    <span class="category-title">Aceites</span>
                </a>
            </div>
            <div class="category-box">
                <a href="/catalog/category/2">
                    <span class="category-title">Repuestos</span>
                </a>
            </div>
            <div class="category-box">
                <a href="/catalog/category/3">
                    <span class="category-title">Lubricantes</span>
                </a>
            </div>
            <div class="category-box">
                <a href="/catalog/category/4">
                    <span class="category-title">Filtros</span>
                </a>
            </div>
            <div class="category-box">
                <a href="/catalog/category/5">
                    <span class="category-title">Baterías</span>
                </a>
            </div>
            <div class="category-box">
                <a href="/catalog/category/6">
                    <span class="category-title">Neumáticos</span>
                </a>
            </div>
        </div>
    </section>
   



    <!--Contacto -->
    <section class="contact-info">
        <a href="https://wa.me/59894547958?text=Hola%2C%20tengo%20una%20en%20consulta%20" target="_blank">
            <img src="/static/img/img_wpp.png" alt="Comuníquese con nosotros"> 
        </a>
        </div>
    </section>






                    
    <?php require_once 'includes/footer.php' ?>
    <?php require_once 'includes/foot.php' ?>
    <script src="/static/js/user_page/home_page.js"></script>


    
</body>

</html>