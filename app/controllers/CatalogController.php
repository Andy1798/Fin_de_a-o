<?php
namespace app\controllers;

use app\models\Product;
use app\models\Category;
use rutex\BaseController;

class CatalogController extends BaseController
{
    public function index()
    {
        $productModel = new Product;
        $categoryModel = new Category;

        try {
            $products = $productModel->getAll();  // Obtener todos los productos
            $categories = $categoryModel->getAll();  // Obtener todas las categorías
        } catch (\Exception $e) {
            $error = "Error al cargar productos y categorías: " . $e->getMessage();
            return $this->view("error", ["error" => $error]);
        }

        return $this->view("catalog/catalog", [
            "products" => $products,
            "categories" => $categories,
            "title" => "Catálogo de Productos"
        ]);
    }

    public function filterByCategory($params)
    {
        $categoryModel = new Category;
        $productModel = new Product;

        try {
            $categoryId = $params['id'] ?? null;

            if (!$categoryId) {
                throw new \Exception("Categoría no especificada.");
            }

            // Obtener productos por categoría
            $products = $productModel->findByCategory($categoryId);

            // Obtener todas las categorías para la barra lateral
            $categories = $categoryModel->getAll();

            // Obtener el nombre de la categoría
            $category = $categoryModel->getNameById($categoryId);

            // Verificar si existe la categoría y establecer el título
            if (isset($category['name'])) {
                $title = "Productos de la Categoría: " . $category['name'];
            } else {
                $title = "Productos de la Categoría: Desconocida";
            }

            // Mostrar los productos filtrados
            return $this->view("catalog/catalog", [
                "products" => $products,
                "categories" => $categories,
                "title" => $title
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
            // Obtener la consulta de búsqueda
            $query = $data['query'] ?? '';

            // Si no hay consulta, mostrar todos los productos
            if (empty($query)) {
                $products = $productModel->getAll();
                $title = "Todos los Productos";
            } else {
                // Buscar productos que coincidan con la consulta
                $products = $productModel->searchProducts($query);
                $title = "Resultados de Búsqueda para '{$query}'";
            }
        } catch (\Exception $e) {
            $products = [];
            $title = "Error de búsqueda: " . $e->getMessage();
        }

        // Obtener todas las categorías para la barra lateral
        $categories = $categoryModel->getAll();

        // Mostrar los productos buscados
        return $this->view("catalog/catalog", [
            "products" => $products,
            "categories" => $categories,
            "title" => $title
        ]);
    }

   public function view_product($params)
{
    $productModel = new Product;

    try {
        $productId = $params['id'] ?? null;

        if (!$productId) {
            throw new \Exception("Producto no especificado.");
        }

        // Obtener el producto por ID
        $product = $productModel->findProductById($productId);

        // Verificar si el producto existe
        if (!$product) {
            throw new \Exception("Producto no encontrado.");
        }

        // Título basado en el nombre del producto
        $title = "Detalles del Producto: " . $product['name'];

        return $this->view("catalog/view_product", [
            "product" => $product,
            "title" => $title
        ]);
    } catch (\Exception $e) {
        return $this->view("error", ["error" => "Error al mostrar el producto: " . $e->getMessage()]);
    }
}


}
