<?php
namespace app\models;

use rutex\Model;

class Product extends Model
{
    protected $table = "products";

    protected $struct = [
        "id" => ["required" => false],
        "name" => ["required" => true],
        "category" => ["required" => true],
        "brand" => ["required" => true],
        "model" => ["required" => true],  // Campo "model" agregado
        "price" => ["required" => true],
        "quantity" => ["required" => true],
        "image" => ["required" => true],
        "description" => ["required" => true]
    ];

    public function findAllProducts()
    {
        $this->select("*");
        return $this->getCursor();
    }

    public function findProductById($id)
    {
        return $this->where("id", "=", $id)->select()->getFirst();
    }

    public function findByCategory($categoryId)
    {
        return $this->where("category", "=", $categoryId)->select()->getCursor();  // Asegúrate de que retorne un cursor o lista de productos
    }


    public function searchProducts($query)
    {
        $query = "%" . $query . "%";
        $sql = "SELECT * FROM products WHERE name LIKE ? OR description LIKE ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param('ss', $query, $query);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
