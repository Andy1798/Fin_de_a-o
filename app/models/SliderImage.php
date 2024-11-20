<?php
namespace app\models;

use rutex\Model;

class SliderImage extends Model
{
    protected $table = "slider_images";

    protected $struct = [
        "id" => ["required" => false],
        "image" => ["required" => true],
        "caption" => ["required" => false],

    ];

    public function findAllImages()
    {
        return $this->select("*")->getCursor();
    }

    public function findImageById($id)
    {
        return $this->where("id", "=", $id)->select()->getFirst();
    }
}