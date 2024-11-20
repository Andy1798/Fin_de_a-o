<?php
namespace app\models;

use rutex\Model;

class Category extends Model
{
    protected $table = "categories";

    protected $struct = [
        "id" => ["required" => false],
        "name" => ["required" => true],
    ];

    public function findAllCategories()
    {
        $this->select("*");
        return $this->getCursor();
    }
    public function getNameById($categoryId)
    {
        return $this->where("id", "=", $categoryId)->select("name")->getFirst();
    }
}
