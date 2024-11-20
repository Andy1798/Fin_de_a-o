<?php

namespace app\models;

use rutex\Model;

class Order extends Model
{
    protected $table = "orders";

    protected $struct = [
        "id" => ["required" => false],
        "user_id" => ["required" => true],
        "status" => ["required" => true],
        "created_at" => ["required" => false],
    ];


    public function createOrder($userId)
    {
        $sqlcmd = "INSERT INTO {$this->table} (user_id, status, created_at) VALUES (?, 'Pendiente', NOW())";
        $stmt = $this->dbconn->prepare($sqlcmd);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        return $this->dbconn->insert_id;
    }


    public function addProductToOrder($orderId, $productId, $quantity, $price)
    {

        $sqlcmd = "INSERT INTO order_products (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
        $stmt = $this->dbconn->prepare($sqlcmd);
        $stmt->bind_param('iiid', $orderId, $productId, $quantity, $price);
        return $stmt->execute();
    }

    public function getAllOrders()
    {
        $sqlcmd = "SELECT orders.*, users.name, users.lastname, users.phone 
                FROM orders 
                JOIN users ON orders.user_id = users.id 
                ORDER BY orders.created_at DESC";
        $stmt = $this->dbconn->prepare($sqlcmd);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }


    public function countUserOrders($userId)
    {
        $sql = "SELECT COUNT(*) as total FROM orders WHERE user_id = ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'] ?? 0;
    }
    public function getOrdersByUserIdPaginated($userId, $limit, $offset)
    {
        $sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param('iii', $userId, $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getOrdersByUserId($userId)
    {
        $orders = $this->where('user_id', '=', $userId)->select()->getCursor();
        return $orders ?? [];
    }
    public function getOrderDetailsById($orderId)
    {
        $sql = "SELECT p.name AS product_name, op.quantity, op.price, (op.quantity * op.price) AS subtotal
                FROM order_products op
                JOIN products p ON op.product_id = p.id
                WHERE op.order_id = ?";

        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();

        $orderDetails = $result->fetch_all(MYSQLI_ASSOC);
        return $orderDetails;
    }
    public function countAllOrders()
    {
        $sql = "SELECT COUNT(*) as total FROM orders";
        $result = $this->dbconn->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }

        return 0;
    }
    public function getOrdersPaginated($limit, $offset)
    {
        $sql = "SELECT orders.*, users.name, users.lastname, users.phone 
                FROM orders 
                JOIN users ON orders.user_id = users.id 
                ORDER BY orders.created_at DESC 
                LIMIT ? OFFSET ?";
        $stmt = $this->dbconn->prepare($sql);
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();

        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }





    public function getOrdersByStatus($status)
    {
        $sqlcmd = "SELECT orders.*, users.name, users.lastname, users.phone 
                FROM orders 
                JOIN users ON orders.user_id = users.id 
                WHERE orders.status = ?";
        $stmt = $this->dbconn->prepare($sqlcmd);
        $stmt->bind_param('s', $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($orders as &$order) {
            $order['total'] = $this->calculateOrderTotal($order['id']);
        }

        return $orders;
    }


    public function getOrdersByDate($startDate = null, $endDate = null)
    {
        $startDate = $startDate ? date('Y-m-d H:i:s', strtotime($startDate . ' 00:00:00')) : null;
        $endDate = $endDate ? date('Y-m-d H:i:s', strtotime($endDate . ' 23:59:59')) : null;

        $sqlcmd = "SELECT orders.*, users.name, users.lastname 
            FROM orders 
            JOIN users ON orders.user_id = users.id 
            WHERE orders.status = 'Finalizado'";
        if ($startDate && $endDate) {
            $sqlcmd .= " AND orders.created_at >= ? AND orders.created_at <= ?";
            $stmt = $this->dbconn->prepare($sqlcmd);
            $stmt->bind_param('ss', $startDate, $endDate);
        } elseif ($startDate) {
            $sqlcmd .= " AND orders.created_at >= ?";
            $stmt = $this->dbconn->prepare($sqlcmd);
            $stmt->bind_param('s', $startDate);
        } elseif ($endDate) {
            $sqlcmd .= " AND orders.created_at <= ?";
            $stmt = $this->dbconn->prepare($sqlcmd);
            $stmt->bind_param('s', $endDate);
        } else {
            $stmt = $this->dbconn->prepare($sqlcmd);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $orders = $result->fetch_all(MYSQLI_ASSOC);

        foreach ($orders as &$order) {
            $order['total'] = $this->calculateOrderTotal($order['id']);
        }

        return $orders;
    }


    public function updateStatus($orderId, $newStatus)
    {
        $this->update($orderId, ['status' => $newStatus]);
    }

    private function calculateOrderTotal($orderId)
    {
        $sqlcmd = "SELECT SUM(quantity * price) AS total FROM order_products WHERE order_id = ?";
        $stmt = $this->dbconn->prepare($sqlcmd);
        $stmt->bind_param('i', $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['total'] ?? 0;
    }

}
