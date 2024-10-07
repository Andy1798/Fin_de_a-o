<?php
namespace app\controllers;

use app\models\Brand;
use rutex\BaseController;

class BrandController extends BaseController
{
    public function index($data)
    {
        $brand = new Brand;
        $data["brands"] = $brand->findAllBrands();
        return $this->view("brands/brand_form", $data);
    }

    public function store($data)
    {
        $brand = new Brand;
        $brand->insert(["name" => $_POST["name"]]);
        $this->redirect("/product");
    }
}
