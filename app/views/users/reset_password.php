<link rel="stylesheet" href="/static/css/user_page/user_form.css">
    <div class="contenedor">
        <div class="form-contenido">
            <form action="/user/update-password" method="POST">
                <h2>Restablecer Clave</h2>

                <?php if (isset($errmsg)) {
                    echo "<p style='color:red;'>$errmsg</p>";
                } ?>
                <?php if (isset($msg)) {
                    echo "<p style='color:green;'>$msg</p>";
                } ?>
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <div class="input-div clave">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="divInput">
                        <h5>Clave</h5>
                        <input type="password" class="input" name="password" required>

                    </div>
                </div>

                <div class="input-div clave">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="divInput">
                        <h5>Confirmar Clave</h5>
                        <input type="password" class="input" name="repass" required>

                    </div>
                </div>
                <input type="submit" class="btn" name="submit" value="Cambiar Clave">
            </form>
        </div>
    </div>
    <script type="text/javascript" src="/static/js/user_page/user_form.js"></script>