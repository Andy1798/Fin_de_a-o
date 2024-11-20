<?php require_once __DIR__ . '/../includes/restrict.php'; ?>
<?php require_once __DIR__ . '/../includes/head.php'; ?>
<link rel="stylesheet" href="/static/css/admin_page/brand_form.css">
</head>
<body>
    
<?php require_once __DIR__ . '/../includes/admin_header.php'; ?>
    

    <!-- Overlay de carga -->
    <div id="loading-overlay">
        <div id="loading-spinner"></div>
    </div>
    <div class="main-content">
    <div class="form-container">
        <a href="/product" class="back-arrow">
            <i class="fas fa-long-arrow-alt-left"></i> Volver
        </a>
        <h1>Agregar Marca</h1>
        <form action="/brand/store" method="POST" id="brandForm">
            <div class="form-group">
                <label for="name">Nombre de la Marca</label>
                <input type="text" name="name" id="name" required>
            </div>
            <button type="submit" class="submit-btn"><i class="fas fa-save"></i> Guardar Marca</button>
        </form>
    </div>
    </div>
    <?php require_once __DIR__ . '/../includes/foot.php'; ?>
    <script src="/static/js/admin_page/brand_form.js"></script>

    </body>

</html>