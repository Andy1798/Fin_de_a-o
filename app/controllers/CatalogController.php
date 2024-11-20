<?php
namespace app\controllers;

use app\models\Product;
use app\models\Category;
use app\models\Brand;
use rutex\BaseController;

class CatalogController extends BaseController
{
    public function index()
    {
        $productModel = new Product;
        $categoryModel = new Category;
        $brandModel = new Brand;

        try {

            $itemsPerPage = 12;
            $currentPage = $_GET['page'] ?? 1;
            $offset = ($currentPage - 1) * $itemsPerPage;


            $products = $productModel->getPublishedProductsPaginated($itemsPerPage, $offset);
            $totalProducts = $productModel->countPublishedProducts(); // Total de productos publicados
            $totalPages = ceil($totalProducts / $itemsPerPage);

            $categories = $categoryModel->getAll();
            $brands = $brandModel->getAll();


            $brandMap = [];
            foreach ($brands as $brand) {
                $brandMap[$brand['id']] = $brand['name'];
            }


            foreach ($products as &$product) {
                $product['brand_name'] = $brandMap[$product['brand']] ?? 'Sin marca';
            }


            $order = $_GET['order'] ?? null;
            if ($order === 'menor') {
                usort($products, fn($a, $b) => $a['price'] <=> $b['price']);
            } elseif ($order === 'mayor') {
                usort($products, fn($a, $b) => $b['price'] <=> $a['price']);
            }
        } catch (\Exception $e) {
            return $this->view("error", ["error" => "Error al cargar productos y categorías: " . $e->getMessage()]);
        }


        return $this->view("catalog/catalog", [
            "products" => $products,
            "categories" => $categories,
            "title" => "Catálogo de Productos",
            "currentPage" => $currentPage,
            "totalPages" => $totalPages
        ]);
    }


    public function filterByCategory($params)
    {
        $categoryModel = new Category;
        $productModel = new Product;
        $brandModel = new Brand;

        try {
            $categoryId = $params['id'] ?? null;

            if (!$categoryId) {
                throw new \Exception("Categoría no especificada.");
            }

            $itemsPerPage = 12;
            $currentPage = $_GET['page'] ?? 1;
            $offset = ($currentPage - 1) * $itemsPerPage;
            $order = $_GET['order'] ?? null;


            $products = $productModel->getProductsByCategoryPaginated($categoryId, $itemsPerPage, $offset, $order);
            $totalProducts = $productModel->countProductsByCategory($categoryId);
            $totalPages = ceil($totalProducts / $itemsPerPage);

            $categories = $categoryModel->getAll();


            $category = $categoryModel->getNameById($categoryId);

            if (isset($category['name'])) {
                $title = "Productos de la Categoría: " . $category['name'];
            } else {
                $title = "Productos de la Categoría: Desconocida";
            }

            $brands = $brandModel->getAll();
            $brandMap = [];
            foreach ($brands as $brand) {
                $brandMap[$brand['id']] = $brand['name'];
            }

            foreach ($products as &$product) {
                $product['brand_name'] = $brandMap[$product['brand']] ?? 'Sin marca';
            }

            return $this->view("catalog/catalog", [
                "products" => $products,
                "categories" => $categories,
                "title" => $title,
                "currentPage" => $currentPage,
                "totalPages" => $totalPages
            ]);
        } catch (\Exception $e) {
            return $this->view("error", ["error" => "Error al filtrar productos: " . $e->getMessage()]);
        }
    }


    public function search($data)
    {
        $productModel = new Product;
        $categoryModel = new Category;

        try {
            $query = $data['query'] ?? '';

            if (empty($query)) {
                $products = $productModel->getAllPublished();
                $title = "Todos los Productos Publicados";
            } else {
                $products = $productModel->searchProducts($query);
                $title = "Resultados de Búsqueda para '{$query}'";
            }
        } catch (\Exception $e) {
            $products = [];
            $title = "Error de búsqueda: " . $e->getMessage();
        }

        $categories = $categoryModel->getAll();

        return $this->view("catalog/catalog", [
            "products" => $products,
            "categories" => $categories,
            "title" => $title
        ]);
    }
    public function view_product($params)
    {
        $productModel = new Product;
        $brandModel = new Brand;

        try {
            $productId = $params['id'] ?? null;

            if (!$productId) {
                throw new \Exception("Producto no especificado.");
            }

            $product = $productModel->findProductById($productId);

            if (!$product) {
                throw new \Exception("Producto no encontrado.");
            }

            $brand = $brandModel->getById($product['brand']);
            $product['brand_name'] = $brand['name'] ?? 'Sin marca';

            $similarProducts = $productModel->findSimilarProductsByCategory($product['category'], $product['id']);

            $title = "Detalles del Producto: " . $product['name'];

            return $this->view("catalog/view_product", [
                "product" => $product,
                "similarProducts" => $similarProducts,
                "title" => $title
            ]);
        } catch (\Exception $e) {
            return $this->view("error", ["error" => "Error al mostrar el producto: " . $e->getMessage()]);
        }
    }

}