<?php 
namespace app\controllers;

use rutex\BaseController;
use app\models\SliderImage;

class HomeController extends BaseController {

    function index($data) {
        $data["title"] = "RUTA-MT INICIO";
        // Recuperar las imágenes del slider
        $sliderImage = new SliderImage;
        $data["sliderImages"] = $sliderImage->findAllImages();

        // Cargar la vista principal
        return $this->view("home", $data);  // Llama a la vista "home.php" desde app/views/
    }

}