<?php

namespace app\controllers;

use rutex\BaseController;

class ImageController extends BaseController
{
    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image'];
                $uploadDirectory = __DIR__ . '/../uploads/';
                $uploadFile = $uploadDirectory . basename($file['name']);

                // Verificar y mover el archivo cargado
                if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'File upload error']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        }
    }
}
