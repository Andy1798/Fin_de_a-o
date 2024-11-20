<?php

namespace app\models;

use rutex\Model;

class Product extends Model
{
    // Definir la tabla en la base de datos
    protected $table = "products";

    // Estructura de la tabla y campos requeridos
    protected $struct = [
        "id" => ["required" => false],
        "name" => ["required" => true],
        "category" => ["required" => true],
        "brand" => ["required" => true],
        "model" => ["required" => true],
        "price" => ["required" => true],
        "quantity" => ["required" => true],
        "image" => ["required" => true],
        "description" => ["required" => true],
        "published" => ["required" => false],
        "featured" => ["required" => false],
        "deleted" => ["required" => false]
    ];

    public function decreaseStock($productId, $quantity)
    {
        $sqlcmd = "UPDATE {$this->table} SET quantity = quantity - ? WHERE id = ? AND quantity >= ?";
        $stmt = $this->dbconn->prepare($sqlcmd);
        $stmt->bind_param('iii', $quantity, $productId, $quantity);

        if ($stmt->execute()) {
            return true;
        } else {
            echo "Error al actualizar el stock: " . $stmt->error;
            return false;
        }
    }

    public function getAllPublished()
    {
        $sql = "SELECT * FROM products WHERE published = 1 AND deleted = 0";
        $stmt = $this->dbconn->prepare($sql);

        if (!$stmt) {
            throw new \Exception("Error al preparar la consulta: " . $this->dbconn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
    }
    public function togglePublished($id, $currentStatus)
    {
        $newStatus = $currentStatus == 1 ? 0 : 1;
        return $this->update($id, ['published' => $newStatus]);
    }

    public function findAllProducts()
    {
        return $this->where('deleted', '=', 0)->select()->getCursor();
    }

    public function findProductById($id)
    {
        return $this->where("id", "=", $id)->select()->getFirst();
    }


    public function findByCategory($categoryId)
    {
        $sql = "SELECT * FROM products WHERE category = ? AND published = 1 AND deleted = 0";
        $stmt = $this->dbconn->prepare($sql);

        if (!$stmt) {
            throw new \Exception("Error al preparar la consulta: " . $this->dbconn->error);
        }

        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();


        $productsByCategory = [];
        while ($row = $result->fetch_assoc()) {
            $productsByCategory[] = $row;
        }

        return $productsByCategory;
    }


    public function searchProducts($query)
    {
        $query = "%" . $query . "%";
        $sql = "SELECT * FROM products 
            WHERE (name LIKE ? OR description LIKE ?) 
            AND published = 1 
            AND deleted = 0";

        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param('ss', $query, $query);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function countPublishedProducts()
    {
        $sql = "SELECT COUNT(*) as total FROM products WHERE published = 1 AND deleted = 0";
        $result = $this->dbconn->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }

        return 0;
    }
    public function getPublishedProductsPaginated($limit, $offset)
    {
        $sql = "SELECT * FROM products WHERE published = 1 AND deleted = 0 LIMIT ? OFFSET ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function countProductsByCategory($categoryId)
    {
        $sql = "SELECT COUNT(*) as total FROM products WHERE category = ? AND published = 1 AND deleted = 0";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param('i', $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'] ?? 0;
    }
    public function getProductsByCategoryPaginated($categoryId, $limit, $offset, $order = null)
    {
        $orderBy = '';
        if ($order === 'menor') {
            $orderBy = 'ORDER BY price ASC';
        } elseif ($order === 'mayor') {
            $orderBy = 'ORDER BY price DESC';
        }

        $sql = "SELECT * FROM products WHERE category = ? AND published = 1 AND deleted = 0 $orderBy LIMIT ? OFFSET ?";
        $stmt = $this->dbconn->prepare($sql);
        if (!$stmt) {
            throw new \Exception("Error al preparar la consulta: " . $this->dbconn->error);
        }

        $stmt->bind_param('iii', $categoryId, $limit, $offset);

        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getFeaturedProducts()
    {
        $sql = "SELECT * FROM products WHERE featured = 1 AND published = 1 AND deleted = 0";
        $stmt = $this->dbconn->prepare($sql);

        if (!$stmt) {
            throw new \Exception("Error al preparar la consulta: " . $this->dbconn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $featuredProducts = [];
        while ($row = $result->fetch_assoc()) {
            $featuredProducts[] = $row;
        }

        return $featuredProducts;
    }
    public function countAllProducts()
    {
        $sql = "SELECT COUNT(*) as total FROM products WHERE deleted = 0";
        $result = $this->dbconn->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }

        return 0;
    }

    public function findProductsPaginated($limit, $offset)
    {
        $sql = "SELECT * FROM products WHERE deleted = 0 LIMIT ? OFFSET ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function findSimilarProductsByCategory($categoryId, $currentProductId = null, $limit = 10)
    {
        if ($categoryId) {
            $sql = "
                SELECT * FROM {$this->table}
                WHERE category = '" . intval($categoryId) . "'
                AND published = 1
                AND deleted = 0
                " . ($currentProductId !== null ? "AND id != '" . intval($currentProductId) . "'" : "") . "
                LIMIT " . intval($limit);

            $results = $this->dbconn->query($sql);

            if ($results) {
                return $results->fetch_all(MYSQLI_ASSOC);
            } else {
                echo "Error en la consulta SQL o no se encontraron resultados.";
            }
        }
        return [];
    }
    public function delete($id)
    {
        return $this->update($id, ['deleted' => 1]);
    }

}