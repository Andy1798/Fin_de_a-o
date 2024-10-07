<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/static/css/admin_page/slider_control.css">

</head>
<body>
<form action="/admin/slider/store" method="POST" enctype="multipart/form-data">
    <label for="image">Subir Imagen:</label>
    <input type="file" name="image" required>
    <label for="caption">Caption (opcional):</label>
    <input type="text" name="caption">
    <button type="submit">Subir Imagen</button>
</form>

<h2>Imágenes Actuales del Slider</h2>

<?php if (!empty($sliderImages)): ?>
    <ul>
        <?php foreach ($sliderImages as $image): ?>
            <li>
                <img src="/<?= $image['image'] ?>" alt="Slider Image" width="200">
                <p><?= $image['caption'] ?></p>
                <form action="/admin/slider/delete/<?= $image['id'] ?>" method="POST">
                    <button type="submit">Eliminar</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>No hay imágenes en el slider.</p>
<?php endif; ?>

</body>
</html>