<?php
namespace app\controllers;

use app\models\SliderImage;
use rutex\BaseController;

class SliderController extends BaseController
{
    public function index($data)
    {
        $sliderImage = new SliderImage;
        $data["title"] = "Slider Home";
        $data["sliderImages"] = $sliderImage->findAllImages(); 
        return $this->view("slider_admin/slider", $data);
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

            $sliderImage->insert([
                "image" => $imagePath,
                "caption" => $_POST["caption"] ?? "",
        
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

        if ($image && file_exists($image['image'])) {
            unlink($image['image']);
        }

        $sliderImage->delete($id);

        $this->redirect("/admin/slider");
    }
}
