<?php 
    use rutex\Route;
    require_once __DIR__ . "/utiles.php";

    //carga las variables de ambiente
    if (is_readable("../.env")) {
        $lines = file("../.env", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if ($line && $line[0]!="#" && strpos($line,"=")>0) {
                [$name, $value] = explode('=', $line, 2);
                $name  = trim($name);
                $value = match(strtolower(trim($value))) {
                    "true"  => true,
                    "false" => false,
                    default => trim($value),
                };
                if (!empty($value)) putenv(sprintf('%s=%s', $name, $value));
            }
        }
    }

    //Configurar auto include de los archivos de clases
    spl_autoload_register(function($className) {

        $parse = explode('\\', $className);

        if (strtolower($parse[0])==="rutex") $script = __DIR__ . "/{$parse[1]}.php";
        else $script = '../' . preg_replace('/\\\\/', '/', $className) . '.php';

        if (is_readable($script)) include_once $script;
        else die("<h1>no se pudo cargar la clase $script ++ $className</h1>");
    });

    session_start();

    //*** RUTAS MAGICAS (se configuran automaticamente aqui) ***
    Route::$magic_urls[] = "ping";
    Route::$magic_urls[] = "engine";
    Route::$magic_urls[] = "conax_return";

    Route::get("/engine", function ($parm) {
        include "engine.php";
        exit;
    });
    
    Route::get("/ping", function ($parm) {
        header("Content-Type: application/json");
        return result(true, $_SERVER["REMOTE_ADDR"]);
    });

    if (empty(getenv("CONAX_SERVER"))) 
        Route::get("/login", function () {return "<h1>Error: Debe configurar 'CONAX_SERVER' en el archivo .env";});

    else {
        Route::get("/login", function ($parm) {
            $conax_server = trim(getenv("CONAX_SERVER"), "/");

            // if (http_get("$conax_server/ping")) say("respuesta: ", http_response());
            // else say("error", http_error());

            // return "<h1>$conax_server</h1>";

            // return "<title>" . getenv("APP_NAME") . "</title>
            //         <link rel=stylesheet href=/static/css/user_form.css>
            //         <div>
            //             <iframe src='$conax_server/user/login' width=100% height=80% frameborder='0' scrolling='no'></iframe>
            //         </div>";

            //Pasar el APIKEY por la url
            return "<title>" . getenv("APP_NAME") . "</title>
                    <link rel=stylesheet href=/static/css/user_form.css>
                    <div>
                        <iframe src='$conax_server/user/login/" . getenv("CONAX_API_KEY") . "' width=100% height=80% frameborder='0' scrolling='no'></iframe>
                    </div>";

        });

        Route::get("/logout", function ($parm) {
            unset($_SESSION["user"]);
            redirect("/");
        });

        Route::get("/conax_return", function ($parm) {
            if (isset($_GET["data"])) {
                $_SESSION["user"] = json_decode(base64_decode($_GET["data"]), true);
            }
            redirect("/");
        });
    }


    //Carga el archivo rutas de la app
    //Si el usuario redefine las rutas magicas, serán SOBREESCRITAS con el valor indicado en web.php
    //Esto se hace para permitir que el usuario modifique el comportamiento por defecto
    require_once "../app/web.php";

    //Procesar la ruta recibida
    Route::listen();

    return;


    function FramesController($parm) {
        //invocado cuando se crea una ruta Route::frameset("/uri", "folder");
        //en "folder" debe haber un archivo "framset.php" con la configuracion de los frames 

        $path     = trim(strtolower(preg_replace("#\?(.*)#", "", $_SERVER["REQUEST_URI"])), "/");

        //El folder es obligatorio y fuè indicado al crear la ruta en web.php;
        $folder   = Route::$currentEntry["folder"];
        $frameset = (include "../app/views/$folder/frameset.php");

        //setea el campo utilizado por el render para armar las rutas
        $frameset["path"] = $path;

        $frame = $_GET["frame"] ?? "panel";

        if (!isset($_GET["frame"])) echo renderLayout("frameset", $frameset);
        else echo view("$folder/$frame", $parm);
    }
