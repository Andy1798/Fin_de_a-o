<?php
namespace app\controllers;

use app\models\Category;
use rutex\BaseController;

class CategoryController extends BaseController
{
    public function index($data)
    {
        $category = new Category;
        $data["categories"] = $category->findAllCategories();
        return $this->view("categories/category_form", $data);
    }

    public function store($data)
    {
        $category = new Category;
        $category->insert(["name" => $_POST["name"]]);
        $this->redirect("/product");
    }
}
