<?php
namespace app\models;

use rutex\Model;

class Brand extends Model
{
    protected $table = "brands";

    protected $struct = [
        "id" => ["required" => false],
        "name" => ["required" => true],
    ];

    public function findAllBrands()
    {
        $this->select("*");
        return $this->getCursor();
    }
}
