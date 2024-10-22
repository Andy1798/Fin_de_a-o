<?php 
namespace app\controllers;

use rutex\BaseController;
use app\models\SliderImage;
use app\models\Product;  // Incluir el modelo de producto

class HomeController extends BaseController {

    function index($data) {
        $data["title"] = "RUTA-MT INICIO";

        // Recuperar las imágenes del slider principal
        $sliderImage = new SliderImage;
        $data["sliderImages"] = $sliderImage->findAllImages();

        // Recuperar productos destacados
        $productModel = new Product;
        $data["featuredProducts"] = $productModel->getFeaturedProducts();  // Método en el modelo Product

        // Cargar la vista principal
        return $this->view("home", $data);  // Llama a la vista "home.php" desde app/views/
    }

}
