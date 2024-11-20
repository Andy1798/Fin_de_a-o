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
            $this->update($existingCart['id'], [
                'quantity' => $existingCart['quantity'] + $quantity,
                'subtotal' => $existingCart['subtotal'] + $subtotal,
            ]);
        } else {
            $this->insert([
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);
        }
    }

    public function syncWithSessionCart($sessionCart, $userId)
    {
        foreach ($sessionCart as $productId => $sessionProduct) {
            $existingProduct = $this->where("user_id", "=", $userId)
                ->where("product_id", "=", $productId)
                ->select()
                ->getFirst();

            if (!$existingProduct) {
                $this->addProductToCart($userId, $productId, $sessionProduct['quantity'], $sessionProduct['subtotal']);
            }
        }
    }

    public function deleteProductFromCart($userId, $productId)
    {
        $userId = $this->dbconn->real_escape_string($userId);
        $productId = $this->dbconn->real_escape_string($productId);

        $sql = "DELETE FROM {$this->table} WHERE user_id = $userId AND product_id = $productId";
        $this->query($sql);

        return $this->affected_rows() > 0;
    }

    public function clearCart($userId)
    {
        $userId = $this->dbconn->real_escape_string($userId);
        $this->query("DELETE FROM {$this->table} WHERE user_id = {$userId}");

        if ($this->dbconn->affected_rows > 0) {
            return true;
        } else {
            return false;
        }
    }
}