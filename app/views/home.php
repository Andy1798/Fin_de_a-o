<?php require_once 'includes/head.php' ?>
<?php require_once 'includes/header.php' ?>


    <!-- SLIDER -->
    <h2>Vista previa del Slider</h2>

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
    <?php require_once 'includes/footer.php' ?>
    <?php require_once 'includes/foot.php' ?>
</body>

</html>