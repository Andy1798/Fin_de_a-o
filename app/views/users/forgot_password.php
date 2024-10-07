<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/static/css/user_page/user_form.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Document</title>
</head>

<body>

    <div class="contenedor">
        <div class="form-contenido">
            <form action="/user/send-reset-email" method="POST">

                <h2>Olvidé mi clave</h2>

                <?php if (isset($errmsg)) {
                    echo "<p style='color:red;'>$errmsg</p>";
                } ?>
                <?php if (isset($msg)) {
                    echo "<p style='color:green;'>$msg</p>";
                } ?>

                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="divInput">
                        <h5>Mail</h5>
                        <input type="mail" class="input" name="mail" value="<?= $mail ?? "" ?>" required>
                    </div>
                </div>
                <input type="submit" class="btn" name="submit" value="Enviar">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="/static/js/user_page/user_form.js"></script>
</body>

</html>