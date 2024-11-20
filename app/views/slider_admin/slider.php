<?php require_once __DIR__ . '/../includes/restrict.php'; ?>
<?php require_once __DIR__ . '/../includes/head.php'; ?>
<link rel="stylesheet" href="/static/css/admin_page/admin_slider.css">
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
</head>
<body>
<?php require_once __DIR__ . '/../includes/admin_header.php'; ?>
<!-- Main Content Area -->
<div id="loading-overlay">
        <div id="loading-spinner"></div>
    </div>
<div class="main-content">
    <form action="/admin/slider/store" method="POST" enctype="multipart/form-data">
        <label for="image">Subir Imagen:</label>
        <input type="file" name="image" required>
        <label for="caption">Caption (opcional):</label>
        <input type="text" name="caption">
        <button type="submit">Subir Imagen</button>
    </form>

    <h2>Vista previa del Slider</h2>

    <?php if (!empty($sliderImages)): ?>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($sliderImages as $image): ?>
                    <div class="swiper-slide">
                        <img src="/<?= $image['image'] ?>" alt="Slider Image">
                        <?php if (!empty($image['caption'])): ?>
                            <div class="caption"><?= $image['caption'] ?></div>
                        <?php endif; ?>
                        <form action="/admin/slider/delete/<?= $image['id'] ?>" method="POST" class="delete-form"
                            onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
                            <button class="delete-button" onclick="confirmDeletion(<?= $image['id'] ?>)">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Flechas de navegación -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>

            <!-- Paginación -->
            <div class="swiper-pagination"></div>
        </div>
    <?php else: ?>
        <p>No hay imágenes en el slider.</p>
    <?php endif; ?>
</div>

<!-- Overlay de carga -->
<div id="loading-overlay">
    <div id="loading-spinner"></div>
</div>
<?php require_once __DIR__ . '/../includes/foot.php'; ?>

<script src="/static/js/admin_page/admin_slider.js"></script>

</body>

</html>