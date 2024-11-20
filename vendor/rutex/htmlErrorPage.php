
<?php  require_once __DIR__ .'/../../app/views/includes/head.php'?>


    <style>
        
        .error-container {
            text-align: center;
            padding: 30px
        }
        .error-code {
            font-size: 6em;
            font-weight: bold;
            color: #d9534f;
        }
        .error-message {
            font-size: 1.5em;
            margin-top: 20px;
            color: #555;
        }
        .suggestion {
            margin-top: 10px;
            font-size: 1.2em;
            color: #777;
        }
        .home-link {
            margin-top: 30px;
            display: inline-block;
            padding: 10px 20px;
            font-size: 1em;
            transition: background-color 0.3s, transform 0.5s;

            color: #fff;
            background-color: #283E81;
            text-decoration: none;
            border-radius: 5px;
        }
        .home-link:hover {
            background-color: #1d2f63;
            transform: scale(1.05);
        }
        .car-icon {
            font-size: 4em;
            color: #f0ad4e;
        }
    </style>
<?php  require_once __DIR__ . '/../../app/views/includes/header.php' ?>

    <div class="error-container">
        <div class="car-icon">🚗💨</div>
        <div class="error-code">404</div>
        <div class="error-message">¡Ups! Parece que te extraviaste de la carretera.</div>
        <div class="suggestion">No te preocupes, aqui te dejo como volver.</div>
        <a href="/" class="home-link">Volver a inicio</a>
    </div>
    <?php require_once __DIR__ . '/../../app/views/includes/foot.php' ?>
<?php require_once __DIR__ .'/../../app/views/includes/footer.php' ?>
</body>
</html>
