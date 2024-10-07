<?php 
namespace app\controllers;

use rutex\BaseController;

class AdminHomeController extends BaseController {

    function homeControl($data) {
        $data["title"] = "Panel de Administración";
        return $this->view("view_home/home_control", $data);  // Cargar la vista de administración
    }

}