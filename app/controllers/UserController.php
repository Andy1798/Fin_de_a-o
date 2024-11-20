<?php

namespace app\controllers;

use rutex\BaseController;
use app\models\User;
use app\models\Cart;
use app\models\Product;
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
        unset($_SESSION["cart"]);
        $this->redirect("/");
    }

    function create($data)
    {
        $data["title"] = "Nuevo Usuario";
        $data["mode"] = "create";
        $data["action"] = "/user/store";
        $data["method"] = "POST";
        return $this->view("users/form", $data);
    }

    //ACCIONES

    public function check($data)
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
            session_regenerate_id(true);
            $_SESSION["userLogged"] = $userInfo;

            if (!empty($_SESSION['cart'])) {
                $cartModel = new Cart();
                $cartModel->syncWithSessionCart($_SESSION['cart'], $_SESSION['userLogged']['id']);
            }

            $_SESSION['cart'] = [];
            $cartModel = new Cart();
            $userCart = $cartModel->findByUserId($_SESSION['userLogged']['id']);

            $productModel = new Product();
            foreach ($userCart as $item) {
                $product = $productModel->findProductById($item['product_id']);
                if ($product) {
                    $_SESSION['cart'][$item['product_id']] = [
                        'name' => $product['name'],
                        'price' => $product['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['subtotal'],
                    ];
                }
            }

            if ($userInfo['role'] === 'admin') {
                $this->redirect("/admin");
            } else {
                $this->redirect("/");
            }
        } else {
            $data["errmsg"] = "Contraseña incorrecta";
            return $this->login($data);
        }
    }


    function store($data)
    {
        $data["name"] = trim($_POST["name"]);
        $data["lastname"] = trim($_POST["lastname"]);
        $data["phone"] = trim($_POST["phone"]);
        $data["mail"] = trim($_POST["mail"]);

        if (empty($data["name"])) {
            $data["errmsg"] = "Debe ingresar un name";
            return $this->create($data);
        } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]{3,}$/u", $data["name"])) {
            $data["errmsg"] = "El name debe contener al menos 3 letras y solo letras";
            return $this->create($data);
        }

        if (empty($data["lastname"])) {
            $data["errmsg"] = "Debe ingresar un lastname";
            return $this->create($data);
        } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ]{3,}$/u", $data["lastname"])) {
            $data["errmsg"] = "El lastname debe contener al menos 3 letras y solo letras";
            return $this->create($data);
        }

        if (empty($data["phone"])) {
            $data["errmsg"] = "Debe ingresar un teléfono";
            return $this->create($data);
        } elseif (!preg_match("/^[0-9]{9}$/", $data["phone"])) {
            $data["errmsg"] = "El teléfono debe contener exactamente 9 dígitos";
            return $this->create($data);
        }

        if (empty($data["mail"])) {
            $data["errmsg"] = "Debe ingresar un mail";
            return $this->create($data);
        } elseif (!filter_var($data["mail"], FILTER_VALIDATE_EMAIL) || strlen(explode('@', $data["mail"])[0]) < 3) {
            $data["errmsg"] = "El mail debe ser válido y tener al menos 3 caracteres antes del @";
            return $this->create($data);
        }

        if (empty($_POST["password"])) {
            $data["errmsg"] = "Debe ingresar una password";
            return $this->create($data);
        } elseif (strlen($_POST["password"]) < 8 || !preg_match("/[A-Z]/", $_POST["password"]) || !preg_match("/[0-9]/", $_POST["password"])) {
            $data["errmsg"] = "La password debe tener al menos 8 caracteres, incluir una mayúscula y un número";
            return $this->create($data);
        }

        if ($_POST["password"] !== $_POST["repass"]) {
            $data["errmsg"] = "Las contraseñas no coinciden";
            return $this->create($data);
        }

        $user = new User;

        $existingUser = $user->where("mail", "=", $data["mail"])->select()->getFirst();
        if ($existingUser) {
            $data["errmsg"] = "Mail ya registrado";
            return $this->create($data);
        }

        $_POST["password"] = password_hash($_POST["password"], PASSWORD_BCRYPT);
        $user->insert($_POST);

        if ($user->success()) {
            $_SESSION["userLogged"] = $user->userLogged();

            header("Location: /");
            exit();
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

    public function sendResetCode($data)
    {
        $email = $_POST["mail"];

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $data["errmsg"] = "Debe ingresar un correo válido.";
            return $this->forgotPassword($data);
        }

        $user = new User();
        $code = $user->generateResetCode($email);

        if ($code) {
            $to = $email;
            $subject = "Código de restablecimiento de contraseña";
            $message = "Tu código de restablecimiento es: $code. Es válido por 10 minutos.";
            $headers = "From: rutamtoficial@gmail.com\r\n";

            if (mail($to, $subject, $message, $headers)) {
                $data["msg"] = "Código enviado a tu correo.";
                $data["mail"] = $email;
                $data["title"] = "Código de restablecimiento"; 
                return $this->view("users/enter_code", $data);
            } else {
                $data["errmsg"] = "Error al enviar el correo. Intente nuevamente.";
            }
        } else {
            $data["errmsg"] = "Correo no registrado.";
        }

        return $this->forgotPassword($data);
    }

    public function verifyCode($data)
    {
        $email = $_POST["mail"];
        $code = $_POST["reset_code"];

        if (empty($code)) {
            $data["errmsg"] = "Debe ingresar el código.";
            $data["mail"] = $email;
            return $this->view("users/enter_code", $data);
        }

        $user = new User();

        if ($user->verifyResetCode($email, $code)) {
            $data["mail"] = $email;
            $data["title"] = "Cambiar Clave";
            return $this->view("users/reset_password", $data);
        } else {
            $data["errmsg"] = "Código inválido o expirado.";
            $data["mail"] = $email;
            $data["title"] = "Cambiar Clave";
            return $this->view("users/enter_code", $data);
        }
    }

    // Actualizar la contraseña
    public function updatePasswordWithCode($data)
    {
        $email = $_POST["mail"];
        $password = $_POST["password"];
        $repass = $_POST["repass"];

        if (empty($password)) {
            $data["errmsg"] = "Debe ingresar una contraseña.";
            $data["mail"] = $email;
            $data["title"] = "Cambiar Clave";
            return $this->view("users/reset_password", $data);
        }

        if (
            strlen($password) < 8 ||
            !preg_match("/[A-Z]/", $password) ||
            !preg_match("/[0-9]/", $password)
        ) {
            $data["errmsg"] = "La contraseña debe tener al menos 8 caracteres, una mayúscula y un número.";
            $data["mail"] = $email;
            $data["title"] = "Cambiar Clave";
            return $this->view("users/reset_password", $data);
        }


        if ($password !== $repass) {
            $data["errmsg"] = "Las contraseñas no coinciden.";
            $data["mail"] = $email;
            $data["title"] = "Cambiar Clave";
            return $this->view("users/reset_password", $data);
        }

        // Actualizar la contraseña
        $user = new User();
        if ($user->resetPasswordWithCode($email, $password)) {

            $_SESSION["success_msg"] = "Contraseña actualizada con éxito. Por favor, inicia sesión.";
            return $this->redirect("/user/login");
        } else {
            $data["errmsg"] = "Error al actualizar la contraseña. Intenta nuevamente.";
            $data["mail"] = $email;
            return $this->view("users/reset_password", $data);
        }
    }

}
