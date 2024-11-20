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
        $category = new Category;
        $brand = new Brand;

        $itemsPerPage = 8;
        $currentPage = $_GET['page'] ?? 1;
        $offset = ($currentPage - 1) * $itemsPerPage;

        $products = $product->findProductsPaginated($itemsPerPage, $offset);
        $totalProducts = $product->countAllProducts();
        $totalPages = ceil($totalProducts / $itemsPerPage);

        $categories = $category->findAllCategories();
        $brands = $brand->findAllBrands();

        $categoryMap = [];
        foreach ($categories as $cat) {
            $categoryMap[$cat['id']] = $cat['name'];
        }

        $brandMap = [];
        foreach ($brands as $br) {
            $brandMap[$br['id']] = $br['name'];
        }

        foreach ($products as &$product) {
            $product['category_name'] = $categoryMap[$product['category']] ?? 'Sin categoría';
            $product['brand_name'] = $brandMap[$product['brand']] ?? 'Sin marca';
        }

        $data["products"] = $products;
        $data["currentPage"] = $currentPage;
        $data["totalPages"] = $totalPages;
        $data["title"] = "Lista de Productos";

        return $this->view("products/list", $data);
    }


    public function create($data)
    {
        $category = new Category;
        $brand = new Brand;

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

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];
            $uploadDir = 'static/img/uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imagePath = $uploadDir . uniqid() . '-' . $imageName;

            if (move_uploaded_file($imageTmpPath, $imagePath)) {
                $quantity = $_POST["quantity"];
                $published = $quantity > 0 ? ($_POST["published"] ?? 1) : 0;
                $product->insert([
                    "name" => $_POST["name"],
                    "category" => $_POST["category"],
                    "brand" => $_POST["brand"],
                    "model" => $_POST["model"],
                    "price" => $_POST["price"],
                    "quantity" => $quantity,
                    "image" => $imagePath,
                    "description" => $_POST["description"],
                    "published" => $published
                ]);

                if ($quantity == 0) {
                    $data["errmsg"] = "El producto se guardó, pero no puede publicarse con cantidad 0.";
                    return $this->view("products/product_form", $data);
                }

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
        $id = $params['id'];
        $product = new Product;

        $category = new Category;
        $brand = new Brand;

        $data["categories"] = $category->findAllCategories();
        $data["brands"] = $brand->findAllBrands();
        $data["product"] = $product->findProductById($id);

        if ($data["product"]) {
            $data["title"] = "Editar Producto";
            $data["action"] = "/product/update/" . $id;
            return $this->view("products/product_form", $data);
        } else {
            $data["errmsg"] = "Producto no encontrado";
            return $this->redirect("/product");
        }
    }

    public function update($params)
    {
        $id = $params['id'];

        $product = new Product;
        $existingProduct = $product->findProductById($id);


        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $imageTmpPath = $_FILES['image']['tmp_name'];
            $imageName = $_FILES['image']['name'];
            $uploadDir = 'static/img/uploads/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $imagePath = $uploadDir . uniqid() . '-' . $imageName;

            if (move_uploaded_file($imageTmpPath, $imagePath)) {
                $imageToSave = $imagePath;
            } else {
                $data["errmsg"] = "Error al mover la imagen";
                return $this->view("products/product_form", $data);
            }
        } else {
            $imageToSave = $existingProduct['image'] ?? null;
        }

        $quantity = $_POST["quantity"];
        $publishedStatus = $quantity > 0 ? $existingProduct['published'] : 0;

        $product->update($id, [
            "name" => $_POST["name"],
            "category" => $_POST["category"],
            "brand" => $_POST["brand"],
            "model" => $_POST["model"],
            "price" => $_POST["price"],
            "quantity" => $quantity,
            "image" => $imageToSave,
            "description" => $_POST["description"],
            "published" => $publishedStatus
        ]);

        $this->redirect("/product");
    }


    public function togglePublished($params)
    {
        $productModel = new Product;

        try {
            $productId = $params['id'] ?? null;
            $publishedStatus = json_decode(file_get_contents("php://input"), true)['published'] ?? null;

            if (!$productId || !isset($publishedStatus)) {
                throw new \Exception("Parámetros inválidos.");
            }

            $product = $productModel->findProductById($productId);

            if ($publishedStatus == 1 && $product['quantity'] == 0) {
                throw new \Exception("No puedes publicar un producto con cantidad 0.");
            }

            $productModel->update($productId, ['published' => $publishedStatus]);

            if ($publishedStatus == 0) {
                $productModel->update($productId, ['featured' => 0]);
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function toggleFeatured($params)
    {
        $productModel = new Product;

        try {
            $productId = $params['id'] ?? null;
            $input = json_decode(file_get_contents("php://input"), true);
            $featuredStatus = $input['featured'] ?? null;

            if (!$productId || !isset($featuredStatus)) {
                throw new \Exception("Parámetros inválidos.");
            }

            $product = $productModel->findProductById($productId);
            if ($product['published'] == 0) {
                throw new \Exception("Tienes que publicar el Producto antes de destacarlo.");
            }

            $productModel->update($productId, ['featured' => $featuredStatus]);
            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function delete($params)
    {
        $id = $params['id'];

        $product = new Product;
        $product->delete($id);
        $this->redirect("/product");
    }



    public function buscar()
    {
        if (isset($_GET['query'])) {
            $query = $_GET['query'];
            $productModel = new Product();
            $productos = $productModel->searchProducts($query);

            header('Content-Type: application/json');
            echo json_encode($productos);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'No se recibió la consulta']);
        }
    }

}
