<?php require_once 'includes/restrict.php' ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Menú Completo</title>
    <link rel="stylesheet" href="/static/css/admin_page/admin_header.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="top-nav">
        <div class="toggle-btn" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </div>
        <div class="top-menu">

        </div>
        <div class="user-info">

            <div class="profile">
                <span><?php echo $_SESSION["userLogged"]["name"] . " " . $_SESSION["userLogged"]["lastname"]; ?></span>
                <br>
                <br>
            </div>
        </div>
    </div>
    <div class="sidebar" id="sidebar">
        <ul class="menu">
            <li><a href="/product"><i class="fas fa-box"></i> <span>PRODUCTO</span></a></li>
            <li><a href="/admin/homecontrol"><i class="fas fa-user-shield"></i> <span>HOME CONTROL</span></a>
            </li>
            <li><a href="/catalog"><i class="fas fa-users-cog"></i> <span>CATALOGO</span></a></li>
            <li><a href="/order"><i class="fas fa-calendar-check"></i> <span>VER PEDIDOS</span></a></li>
            <li><a href=""><i class="fas fa-calendar-check"></i> <span>VER RESERVAS</span></a></li>
        </ul>
    </div>
    <div class="main-content">
        messi y antonella
    </div>


    </div>
    <script src="/static/js/admin_page/admin_page.js"></script>
</body>

</html>