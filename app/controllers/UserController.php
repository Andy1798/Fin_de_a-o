<?php

namespace app\controllers;

use rutex\BaseController;
use app\models\User;

class UserController extends BaseController
{
    //INTERFACES
    function login($data)
    {
        $data["title"] = "Login";
        $data["mode"] = "login";
        $data["action"] = "/user/login";
        $data["method"] = "POST";
        return $this->view("users/form", $data);
    }

    function logout($data)
    {
        unset($_SESSION["userLogged"]);
        $this->redirect("/");
    }

    function create($data)
    {
        //Formulario para crear un usuario
        $data["title"] = "Nuevo Usuario";
        $data["mode"] = "create";
        $data["action"] = "/user/store";
        $data["method"] = "POST";
        return $this->view("users/form", $data);
    }

    //ACCIONES
    function check($data)
    {
        $data["mail"] = $_POST["mail"];

        if (empty($_POST["mail"])) {
            $data["errmsg"] = "Debe ingresar un mail de usuario";
            return $this->login($data);
        }

        if (empty($_POST["password"])) {
            $data["errmsg"] = "Debe ingresar la password";
            return $this->login($data);
        }

        $user = new User;
        $userInfo = $user->where("mail", "=", $_POST["mail"])->select()->getFirst();

        if ($user->affected_rows() == 0) {
            $data["errmsg"] = "Usuario no registrado. Ingrese sus datos";
            return $this->create($data);
        } else if (password_verify($_POST["password"], $userInfo["password"])) {
            $_SESSION["userLogged"] = $user->userLogged();

            if ($userInfo["role"] === 'admin') {
                $this->redirect("/admin");
            } else {
                $this->redirect("/");
            }
        } else {
            $data["errmsg"] = "password incorrecta";
            return $this->login($data);
        }
    }

    function store($data)
    {
        $data["name"] = $_POST["name"];
        $data["lastname"] = $_POST["lastname"];
        $data["phone"] = $_POST["phone"];
        $data["mail"] = $_POST["mail"];

        // Validación del name
        if (empty($_POST["name"])) {
            $data["errmsg"] = "Debe ingresar un name";
            return $this->create($data);
        } elseif (!preg_match("/^[a-zA-Z]{3,}$/", $_POST["name"])) {
            $data["errmsg"] = "El name debe contener al menos 3 letras y solo letras";
            return $this->create($data);
        }

        // Validación del lastname
        if (empty($_POST["lastname"])) {
            $data["errmsg"] = "Debe ingresar un lastname";
            return $this->create($data);
        } elseif (!preg_match("/^[a-zA-Z]{3,}$/", $_POST["lastname"])) {
            $data["errmsg"] = "El lastname debe contener al menos 3 letras y solo letras";
            return $this->create($data);
        }

        // Validación del teléfono
        if (empty($_POST["phone"])) {
            $data["errmsg"] = "Debe ingresar un teléfono";
            return $this->create($data);
        } elseif (!preg_match("/^[0-9]{9}$/", $_POST["phone"])) {
            $data["errmsg"] = "El teléfono debe contener exactamente 9 dígitos";
            return $this->create($data);
        }

        // Validación del mail
        if (empty($_POST["mail"])) {
            $data["errmsg"] = "Debe ingresar un mail";
            return $this->create($data);
        } elseif (!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL) || strlen(explode('@', $_POST["mail"])[0]) < 3) {
            $data["errmsg"] = "El mail debe ser válido y tener al menos 3 caracteres antes del @";
            return $this->create($data);
        }

        // Validación de la password
        if (empty($_POST["password"])) {
            $data["errmsg"] = "Debe ingresar una password";
            return $this->create($data);
        } elseif (strlen($_POST["password"]) < 8 || !preg_match("/[A-Z]/", $_POST["password"]) || !preg_match("/[0-9]/", $_POST["password"])) {
            $data["errmsg"] = "La password debe tener al menos 8 caracteres, incluir una mayúscula y un número";
            return $this->create($data);
        }

        // Verificar coincidencia de passwords
        if ($_POST["password"] !== $_POST["repass"]) {
            $data["errmsg"] = "Las contraseñas no coinciden";
            return $this->create($data);
        }

        $user = new User;

        // Verificar si el mail ya está registrado
        $existingUser = $user->where("mail", "=", $_POST["mail"])->select()->getFirst();
        if ($existingUser) {
            $data["errmsg"] = "mail ya registrado";
            return $this->create($data);
        }


        $_POST["password"] = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $user->insert($_POST);

        if ($user->success()) {
            $_SESSION["userLogged"] = $user->userLogged();
            // Redirigir basado en el rol
            if ($_POST["mail"] === 'admin@gmail.com') {
                $this->redirect("/admin");
            } else {
                $this->redirect("/");
            }
        } else {
            $data["errmsg"] = $user->content();
            return $this->create($data);
        }
    }

    // Restablecimiento de contraseña
    public function forgotPassword($data)
    {
        $data["title"] = "Olvidé mi clave";
        return $this->view("users/forgot_password", $data);
    }

    public function sendResetEmail($data)
    {
        $user = new User;
        $userInfo = $user->where("mail", "=", $_POST["mail"])->select()->getFirst();

        if (!$userInfo) {
            $data["errmsg"] = "Correo no registrado";
            return $this->forgotPassword($data);
        }

        // Generar el token de restablecimiento
        $token = $user->generateResetToken();

        // Crear el enlace para el restablecimiento de contraseña
        $resetLink = "https://rutamt.zonafranja.com/user/reset-password?token=" . $token;

        // Datos del correo
        $to = $userInfo["mail"];
        $subject = "Restablecimiento de contraseña";
        $headers = "From: rutamtoficial@gmail.com\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n"; // Asegurar que el contenido sea HTML
        $message = "<html><body>";
        $message .= "<p>Haz clic en el siguiente enlace para restablecer tu contraseña: </p><a href='" . $resetLink . "'>Restablecer contraseña</a>";

        $message .= "</body></html>";

        // Enviar el correo
        if (mail($to, $subject, $message, $headers)) {
            $data["msg"] = "Correo de restablecimiento enviado";
        } else {
            $data["errmsg"] = "Error al enviar el correo";
        }

        return $this->forgotPassword($data);
    }


    public function resetPassword($data)
    {
        if (!isset($_GET["token"])) {
            $data["errmsg"] = "Token no válido";
            return $this->login($data);
        }

        $user = new User;
        if (!$user->findByResetToken($_GET["token"])) {
            $data["errmsg"] = "Token no válido o expirado";
            return $this->login($data);
        }

        $data["token"] = $_GET["token"];
        $data["title"] = "Restablecer Contraseña";
        return $this->view("users/reset_password", $data);
    }

    public function updatePassword($data)
    {
        $token = $_POST["token"];
        $newPassword = $_POST["password"];
        $repass = $_POST["repass"];

        if ($newPassword !== $repass) {
            $data["errmsg"] = "Las contraseñas no coinciden";
            return $this->resetPassword($data);
        }

        $user = new User;
        if ($user->resetPassword($token, $newPassword)) {
            $data["msg"] = "Contraseña actualizada con éxito";
            return $this->login($data);
        } else {
            $data["errmsg"] = "Token no válido o expirado";
            return $this->resetPassword($data);
        }
    }
}
