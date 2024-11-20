<?php
namespace app\controllers;

use rutex\BaseController;
use app\models\SliderImage;
use app\models\Product;

class HomeController extends BaseController
{

    function index($data)
    {
        $data["title"] = "RUTA-MT INICIO";


        $sliderImage = new SliderImage;
        $data["sliderImages"] = $sliderImage->findAllImages();


        $productModel = new Product;
        $data["featuredProducts"] = $productModel->getFeaturedProducts();

        // Cargar la vista principal
        return $this->view("home", $data);
    }

}
