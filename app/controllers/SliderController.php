<?php
namespace app\controllers;

use app\models\SliderImage;
use rutex\BaseController;

class SliderController extends BaseController
{
    public function index($data)
    {
        $sliderImage = new SliderImage;
        $data["sliderImages"] = $sliderImage->findAllImages(); // Ahora recupera sin orden
        return $this->view("viewHome/slider", $data);
    }

    public function store($data)
{
    $sliderImage = new SliderImage;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $_FILES['image']['tmp_name'];
        $imageName = $_FILES['image']['name'];
        $uploadDir = 'static/img/slider/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imagePath = $uploadDir . uniqid() . '-' . $imageName;

        if (move_uploaded_file($imageTmpPath, $imagePath)) {
            // Insertar la imagen sin el campo 'position'
            $sliderImage->insert([
                "image" => $imagePath,
                "caption" => $_POST["caption"] ?? "",
                // "position" => $_POST["position"] // Eliminar esta línea
            ]);
        }
    }

    $this->redirect("/admin/slider");
}

    public function delete($params)
    {
        $id = $params['id'];
        $sliderImage = new SliderImage;
        $image = $sliderImage->findImageById($id);

        // Eliminar la imagen del sistema de archivos
        if ($image && file_exists($image['image'])) {
            unlink($image['image']);
        }

        // Eliminar de la base de datos
        $sliderImage->delete($id);

        $this->redirect("/admin/slider");
    }
}
