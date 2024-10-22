
<?php require_once __DIR__ . '/../includes/restrict.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Marca</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/static/css/admin_page/brand_form.css">
</head>

<body>
    <div class="form-container">
        <a href="/product" class="back-arrow">
            <i class="fas fa-long-arrow-alt-left"></i> Volver
        </a>
        <h1>Agregar Marca</h1>
        <form action="/brand/store" method="POST">
            <div class="form-group">
                <label for="name">Nombre de la Marca</label>
                <input type="text" name="name" id="name" required>
            </div>
            <button type="submit" class="submit-btn"><i class="fas fa-save"></i> Guardar Marca</button>
        </form>
    </div>

</body>

</html>
