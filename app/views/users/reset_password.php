<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once __DIR__ . '/../includes/head.php'; ?>

    <link rel="stylesheet" href="/static/css/user_page/user_form.css">
    <title>Restablecer Contraseña</title>
</head>

<body>
    <div class="contenedor">
        <div class="logo-container">
            <img src="/static/img/rutamtblack.png" alt="Logo">
        </div>
        <div class="form-contenido">

            <?php if (!empty($errmsg)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($errmsg); ?></p>
            <?php endif; ?>

            <form action="/user/update-password-with-code" method="POST">
            <h2>Cambiar Clave</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="divInput">
                        <h5 onclick="focusInput(this)">Nueva Clave</h5>
                        <input type="hidden" name="mail" value="<?php echo htmlspecialchars($mail); ?>">
                        <input type="password" class="input" id="password" name="password" required>
                    </div>
                </div>

                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="divInput">
                        <h5 onclick="focusInput(this)">Confirmar Clave</h5>

                        <input type="password" class="input" id="repass" name="repass" required>
                    </div>
                </div>

                <button type="submit" class="btn">Actualizar Contraseña</button>
            </form>
        </div>
    </div>
    <?php require_once __DIR__ . '/../includes/foot.php'; ?>
    <script src="/static/js/user_page/user_form.js"></script>
</body>

</html>