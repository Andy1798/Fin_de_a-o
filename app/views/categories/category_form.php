<?php require_once __DIR__ . '/../includes/restrict.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="/static/css/admin_page/category_form.css">
</head>

<body>

    <form action="/category/store" method="POST">
        <label for="name">Nueva Categoría:</label>
        <div class="form-row">
            <input type="text" name="name" id="name" required>
            <button type="submit">Guardar</button>
            
        </div>
    </form>
 
    <script src="/static/js/admin_page/category_form.js"></script>
</body>

</html>