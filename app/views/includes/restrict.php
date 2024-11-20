<?php 
if(!isset($_SESSION["userLogged"]) || $_SESSION["userLogged"]['role'] !== 'admin') {
    header('Location: /');
    exit();
}