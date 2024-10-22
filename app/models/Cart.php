<?php

namespace app\models;

use rutex\Model;

class Cart extends Model
{
    protected $table = "cart";

    protected $struct = [
        "id" => ["required" => false],
        "user_id" => ["required" => true],
        "product_id" => ["required" => true],
        "quantity" => ["required" => true],
        "subtotal" => ["required" => true],
    ];

    public function findByUserId($userId)
    {
        return $this->where('user_id', '=', $userId)->select()->getCursor();
    }

    public function addProductToCart($userId, $productId, $quantity, $subtotal)
    {
        $existingCart = $this->where('user_id', '=', $userId)
            ->where('product_id', '=', $productId)
            ->select()
            ->getFirst();

        if ($existingCart) {
            // Si el producto ya está en el carrito, actualizamos la cantidad y el subtotal
            $this->update($existingCart['id'], [
                'quantity' => $existingCart['quantity'] + $quantity,
                'subtotal' => $existingCart['subtotal'] + $subtotal,
            ]);
        } else {
            // Si no está, lo insertamos
            $this->insert([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);
        }
    }

    public function clearCart($userId)
    {
        // Aquí usamos una consulta personalizada para eliminar todos los productos del carrito del usuario
        $userId = $this->dbconn->real_escape_string($userId);
        $this->query("DELETE FROM {$this->table} WHERE user_id = {$userId}");
    
        if ($this->affected_rows() > 0) {
            $this->setResult(true, "Carrito vaciado correctamente.");
            return true;
        } else {
            $this->setResult(false, "No se pudo vaciar el carrito.");
            return false;
        }
    }
}