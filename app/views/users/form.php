<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/user_page/user_form.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title><?= getenv("APP_NAME") ?></title>
    <style>
        .errmsg {
            position: relative;
            background-color: #ffe6e6;
            /* Color de fondo suave para el mensaje de error */
            border: 1px solid #ffcccc;
            /* Borde rojo claro para el mensaje de error */
            border-radius: 4px;
            /* Bordes redondeados */
            padding: 10px;
            margin-top: 5px;
            font-size: 14px;
            display: flex;
            align-items: center;
        }

        .errmsg::before {
            content: '⚠';
            /* Icono de advertencia */
            font-size: 18px;
            margin-right: 8px;
        }

        .errmsg span {
            font-weight: bold;
            color: #d8000c;
            /* Rojo intenso para el texto del error */
        }

        .errmsg p {
            margin: 0;
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <div class="form-contenido">
            <form method="POST" action=<?= $action ?>>


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
                            <h5>Nombre</h5>
                            <input type="text" class="input" name="name" value="<?= $name ?? "" ?>" required>
                        </div>
                    </div>

                <?php endif ?>

                <?php if ($mode == "create"): ?>
                    <div class="input-div one">
                        <div class="i">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="divInput">
                            <h5>Apellido</h5>
                            <input type="text" class="input" name="lastname" value="<?= $lastname ?? "" ?>" required>
                        </div>
                    </div>

                <?php endif ?>

                <?php if ($mode == "create"): ?>
                    <div class="input-div one">
                        <div class="i">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="divInput">
                            <h5>Telefono</h5>
                            <input type="text" class="input" name="phone" value="<?= $phone ?? "" ?>" required>
                        </div>
                    </div>

                <?php endif ?>


                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="divInput">
                        <h5>Mail</h5>
                        <input type="mail" class="input" name="mail" value="<?= $mail ?? "" ?>" required>
                    </div>
                </div>

                <div class="input-div clave">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="divInput">
                        <h5>Clave</h5>
                        <input type="password" class="input" name="password" required>

                    </div>
                </div>

                <?php if ($mode == "create"): ?>
                    <div class="input-div clave">
                        <div class="i">
                            <i class="fas fa-lock"></i>
                        </div>
                        <div class="divInput">
                            <h5>Confirmar Clave</h5>
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
                    <input type="submit" class="btn" onclick="location.href='/';" value="Cancelar">
                    <a href="/user/create">¿No tienes cuenta? Click aquí</a>
                <?php else: ?>
                    <input type="submit" class="btn" name="submit" value="Registrarse">
                    <input type="submit" class="btn" onclick="location.href='/';" value="Cancelar">
                    <a href="/user/login">¿Ya tienes cuenta? Click aquí</a>
                <?php endif ?>


            </form>

        </div>

    </div>
    <script type="text/javascript" src="/static/js/user_page/user_form.js"></script>
</body>

</html>