<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once __DIR__ . '/../includes/head.php'; ?>

    <link rel="stylesheet" href="/static/css/user_page/user_form.css">
    <title>Olvidé mi contraseña</title>
</head>

<body>
    <div class="contenedor">
        <div class="logo-container">
            <img src="/static/img/rutamtblack.png" alt="Logo">
        </div>
        <div class="form-contenido">



            <form action="/user/send-reset-code" method="POST">
                <?php if (!empty($errmsg)): ?>
                    <p class="errmsg"><?php echo htmlspecialchars($errmsg); ?></p>
                <?php endif; ?>

                <?php if (!empty($msg)): ?>
                    <p class="msg"><?php echo htmlspecialchars($msg); ?></p>
                <?php endif; ?>
                <h2>Ingresar Mail</h2>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="divInput">
                        <h5 onclick="focusInput(this)">Mail</h5>
                        <input type="email" class="input" id="mail" name="mail" required>
                    </div>
                </div>
                <button class="btn" type="submit">Enviar Código</button>
                <button type="button" class="btn" onclick="location.href='/user/login';">Cancelar</button>


            </form>
        </div>
    </div>
    <?php require_once __DIR__ . '/../includes/foot.php'; ?>
    <script src="/static/js/user_page/user_form.js"></script>
</body>

</html>