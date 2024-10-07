<?php require_once __DIR__ . '/../includes/restrict.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nueva Marca</title>
    <link rel="stylesheet" href="/static/css/admin_page/brand_form.css">
</head>
<body>
    <form action="/brand/store" method="POST">
        <label for="name">Nueva Marca:</label>
        <input type="text" name="name" id="name" required>
        <button type="submit">Guardar</button><br>
        <button href="/admin">Volver Admin</button>
    </form>
</body>
</html>
