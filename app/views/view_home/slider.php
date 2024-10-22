<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/admin_page/slider_control.css">
      <link rel="stylesheet" href="/static/css/admin_page/admin_header.css">
          <link rel="stylesheet" href="/static/css/admin_page/visualhomepage.css">
          <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
        <!-- Top Navigation Bar -->
        <div class="top-nav">
        <div class="toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </div>
        <div class="user-info">
            <span><?php echo $_SESSION["userLogged"]["name"] . " " . $_SESSION["userLogged"]["lastname"]; ?></span>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
        <ul class="menu">
            <li><a href="/product"><i class="fas fa-box"></i> <span>PRODUCTO</span></a></li>
            <li><a href="/admin/homecontrol"><i class="fas fa-user-shield"></i> <span>HOME CONTROL</span></a></li>
            <li><a href="/catalog"><i class="fas fa-users-cog"></i> <span>CATALOGO</span></a></li>
            <li><a href="/order"><i class="fas fa-calendar-check"></i> <span>VER PEDIDOS</span></a></li>
            <li><a href=""><i class="fas fa-calendar-check"></i> <span>VER RESERVAS</span></a></li>
        </ul>
    </div>

    <!-- Main Content Area -->
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
                    <form action="/admin/slider/delete/<?= $image['id'] ?>" method="POST" class="delete-form" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');">
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

<script src="/static/js/admin_page/admin_page.js"></script>
<script src="https://kit.fontawesome.com/f8e1a90484.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script src="/static/js/user_page/home_page.js"></script>
</body>

</html>