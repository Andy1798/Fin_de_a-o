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
        // Eliminar la línea de position ya que no lo necesitas
        // "position" => ["required" => true] // Eliminar o comentar esta línea
    ];

    public function findAllImages()
    {
        // Recuperar las imágenes sin ordenar
        return $this->select("*")->getCursor();
    }

    public function findImageById($id)
    {
        return $this->where("id", "=", $id)->select()->getFirst();
    }
}