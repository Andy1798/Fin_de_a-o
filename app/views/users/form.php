<?php require_once __DIR__ . '/../includes/head.php'; ?>
<link rel="stylesheet" href="/static/css/user_page/user_form.css">
</head>
<body>

<div class="contenedor">
    <div class="logo-container">
        <img src="/static/img/rutamtblack.png" alt="Logo">
    </div>
    <div class="form-contenido">
        <form method="POST" action="<?= $action ?>">

            <?php if (isset($method)): ?>
                <input type="hidden" name="_method" value=<?= $method ?>>
            <?php endif ?>


            <?php if ($mode == "login"): ?>
                <h2>LOGUEARSE</h2>
            <?php else: ?>
                <h2>REGISTRARSE</h2>
            <?php endif ?>
            <?php if ($mode == "create"): ?>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="divInput">
                        <h5 onclick="focusInput(this)">Nombre</h5>
                        <input type="text" class="input" name="name" value="<?= $name ?? "" ?>" maxlength="16" required>
                    </div>
                </div>

            <?php endif ?>

            <?php if ($mode == "create"): ?>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="divInput">
                        <h5 onclick="focusInput(this)">Apellido</h5>
                        <input type="text" class="input" name="lastname" value="<?= $lastname ?? "" ?>" maxlength="16"
                            required>
                    </div>
                </div>

            <?php endif ?>

            <?php if ($mode == "create"): ?>
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="divInput">
                        <h5 onclick="focusInput(this)">Telefono</h5>
                        <input type="text" class="input" name="phone" value="<?= $phone ?? "" ?>" required>
                    </div>
                </div>

            <?php endif ?>


            <div class="input-div one">
                <div class="i">
                    <i class="fas fa-user"></i>
                </div>
                <div class="divInput">
                    <h5 onclick="focusInput(this)">Mail</h5>
                    <input type="mail" class="input" name="mail" value="<?= $mail ?? "" ?>" required>
                </div>
            </div>

            <div class="input-div clave">
                <div class="i">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="divInput">
                    <h5 onclick="focusInput(this)">Clave</h5>
                    <input type="password" class="input" name="password" autocomplete="off" required>

                </div>
            </div>

            <?php if ($mode == "create"): ?>
                <div class="input-div clave">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="divInput">
                        <h5 onclick="focusInput(this)">Confirmar Clave</h5>
                        <input type="password" class="input" name="repass" required>

                    </div>
                </div>
            <?php endif ?>

            <?php if (isset($errmsg)): ?>
                <div class="errmsg">
                    <span><?= htmlspecialchars($errmsg, ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            <?php endif ?>
            <?php if ($mode == "login"): ?>
                <a href="/user/forgot-password">¿Olvidaste tu clave? Click aquí</a>
            <?php endif ?>

            <?php if ($mode == "login"): ?>
                <input type="submit" class="btn" name="submit" value="Loguearse">
                <button type="button" class="btn" onclick="location.href='/';">Cancelar</button>
                <a href="/user/create">¿No tienes cuenta? Click aquí</a>
            <?php else: ?>
                <input type="submit" class="btn" name="submit" value="Registrarse">
                <button type="button" class="btn" onclick="location.href='/';">Cancelar</button>
                <a href="/user/login">¿Ya tienes cuenta? Click aquí</a>
            <?php endif ?>


        </form>

    </div>

</div>

<?php require_once __DIR__ . '/../includes/foot.php'; ?>
<script src="/static/js/user_page/user_form.js"></script>

</body>

</html>