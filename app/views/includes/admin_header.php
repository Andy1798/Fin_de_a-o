<link rel="icon" href="/static/img/rutamt.ico" type="image/x-icon">
<div class="top-nav">
    <div class="toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </div>
    <div class="top-menu"></div>
    <div class="user-info">
        <div class="profile">
            <span><?php echo $_SESSION["userLogged"]["name"] . " " . $_SESSION["userLogged"]["lastname"]; ?></span>
        </div>
    </div>
</div>

<div class="sidebar" id="sidebar">
    <ul class="menu">
        <li>
            <a href="/product"><i class="fas fa-box"></i> <span>PRODUCTO</span>

            </a>

        </li>
        <li><a href="/admin/slider"><i class="fa-solid fa-sliders"></i><span>SLIDER HOME</span></a></li>
        <li><a href="/catalog"><i class="fa-solid fa-book"></i> <span>CATÁLOGO</span></a></li>
        <li><a href="/admin"><i class="fa-solid fa-list"></i> <span>VER PEDIDOS</span></a></li>
        <li><a href="/earnings"><i class="fa-solid fa-arrow-trend-up"></i><span>VER GANANCIAS</span></a></li>
    </ul>
</div>