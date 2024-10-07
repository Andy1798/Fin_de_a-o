<?php

namespace app\controllers;

use app\models\Product;
use app\models\Category;
use app\models\Brand;
use rutex\BaseController;

class ProductController extends BaseController
{
    public function index($data)
    {
        $product = new Product;
        $data["products"] = $product->findAllProducts();
        $data["title"] = "Lista de Productos";
        return $this->view("products/list", $data);
    }

    public function create($data)
    {
        $category = new Category;
        $brand = new Brand;

        // Obtener categorías y marcas
        $data["categories"] = $category->findAllCategories(); 
        $data["brands"] = $brand->findAllBrands(); 

        $data["title"] = "Nuevo Producto";
        $data["action"] = "/product/store";
        $data["method"] = "POST";
        return $this->view("products/product_form", $data);
    }

    public function store($data)
    {
        $product = new Product;

        // Manejar la subida de la imagen
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];
            $uploadDir = 'static/img/uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Crear la carpeta si no existe
            }

            $imagePath = $uploadDir . uniqid() . '-' . $imageName;

            if (move_uploaded_file($imageTmpPath, $imagePath)) {
                // Insertar el producto en la base de datos
                $product->insert([
                    "name" => $_POST["name"],
                    "category" => $_POST["category"],
                    "brand" => $_POST["brand"],
                    "model" => $_POST["model"],  // Campo "model" agregado
                    "price" => $_POST["price"],
                    "quantity" => $_POST["quantity"],
                    "image" => $imagePath,
                    "description" => $_POST["description"]
                ]);
            } else {
                $data["errmsg"] = "Error al mover la imagen";
                return $this->view("products/product_form", $data);
            }
        } else {
            $data["errmsg"] = "Debe seleccionar una imagen";
            return $this->view("products/product_form", $data);
        }

        $this->redirect("/product");
    }

    public function edit($params)
    {
        $id = $params['id']; // Extrae el ID del array de parámetros
        $product = new Product;

        $category = new Category;
        $brand = new Brand;

        // Obtener categorías y marcas
        $data["categories"] = $category->findAllCategories(); 
        $data["brands"] = $brand->findAllBrands(); 
        $data["product"] = $product->findProductById($id);

        if ($data["product"]) {
            $data["title"] = "Editar Producto";
            $data["action"] = "/product/update/".$id;
            return $this->view("products/product_form", $data);
        } else {
            $data["errmsg"] = "Producto no encontrado";
            return $this->redirect("/product");
        }
    }

    public function update($params)
    {
        $id = $params['id']; // Extrae el ID del array de parámetros

        $product = new Product;
        $existingProduct = $product->findProductById($id);

        // Verificar si se ha subido una nueva imagen
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];
            $uploadDir = 'static/img/uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true); // Crear el directorio si no existe
            }

            $imagePath = $uploadDir . uniqid() . '-' . $imageName;

            // Mover la nueva imagen al directorio de destino
            if (move_uploaded_file($imageTmpPath, $imagePath)) {
                $imageToSave = $imagePath; // Nueva imagen guardada
            } else {
                $data["errmsg"] = "Error al mover la imagen";
                return $this->view("products/product_form", $data);
            }
        } else {
            // Mantener la imagen existente si no se subió una nueva
            $imageToSave = $existingProduct['image'];
        }

        // Actualizar el producto en la base de datos
        $product->update($id, [
            "name" => $_POST["name"],
            "category" => $_POST["category"],
            "brand" => $_POST["brand"],
            "model" => $_POST["model"],  // Campo "model" agregado
            "price" => $_POST["price"],
            "quantity" => $_POST["quantity"],
            "image" => $imageToSave, // Guardar la imagen, ya sea nueva o existente
            "description" => $_POST["description"]
        ]);

        $this->redirect("/product");
    }

    public function delete($params)
    {
        $id = $params['id']; // Extrae el ID del array de parámetros

        $product = new Product;
        $product->delete($id); // Eliminar el producto por su ID
        $this->redirect("/product"); // Redirigir a la lista de productos
    }
}
