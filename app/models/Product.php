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
        "description" => ["required" => true],
        "published" => ["required" => false],
        "featured" => ["required" => false]
    ];

    public function getAllPublished()
    {
        return $this->where('published', '=', 1)->select()->getCursor();  // Solo productos publicados
    }

    // Método para cambiar el estado de publicación de un producto
    public function togglePublished($id, $currentStatus)
    {
        // Determina el nuevo estado
        $newStatus = $currentStatus == 1 ? 0 : 1;
    
        // Llama al método update con el id y el array con el campo 'published'
        return $this->update($id, ['published' => $newStatus]);
    }
    
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
    public function getFeaturedProducts() {
        return $this->where('featured', '=', 1)->select()->getCursor();  // Solo productos destacados
    }
    
}
