<?php
namespace app\controllers;

use app\models\Order;
use app\models\User;
use rutex\BaseController;

class OrderController extends BaseController
{
    protected function getUserInfo()
    {
        return $_SESSION['userLogged'] ?? null; 
    }
    protected function ensureLoggedIn()
    {
        if (!isset($_SESSION['userLogged'])) {
            header('Location: /'); 
            exit();
        }
    }
    public function index($data)
{
    $orderModel = new Order();

   
    $itemsPerPage = 10; 
    $currentPage = $_GET['page'] ?? 1; 
    $offset = ($currentPage - 1) * $itemsPerPage;

    
    $orders = $orderModel->getOrdersPaginated($itemsPerPage, $offset);
    $totalOrders = $orderModel->countAllOrders();
    $totalPages = ceil($totalOrders / $itemsPerPage);

  
    $data["title"] = "Listado de Órdenes";
    $data['orders'] = $orders; 
    $data['userInfo'] = $this->getUserInfo();
    $data["currentPage"] = $currentPage;
    $data["totalPages"] = $totalPages;

    return $this->view('orders/admin_orders', $data);
}

    public function changeStatus($params)
    {
        $orderId = $params['id'];
        $newStatus = $_POST['status'];

        $orderModel = new Order();
        $orderModel->updateStatus($orderId, $newStatus);

      
        $userModel = new User();
        $order = $orderModel->where('id', '=', $orderId)->select()->getFirst();
        $user = $userModel->where('id', '=', $order['user_id'])->select()->getFirst();

        $phone = '+598' . $user['phone']; 
        $fullName = $user['name'] . ' ' . $user['lastname'];

        $messages = [
            'Finalizado' => "Hola $fullName, Muchas gracias por confiar en nosotros",
            'Cancelado' => "Hola $fullName, lamentamos informarte que tu pedido fue cancelado. Si tiene alguna duda, comuníquese por acá.",
            'Pronto' => "Hola $fullName, tu pedido está pronto. Puede pasar a recoger su pedido por Ruta-MT.",
            'Pendiente' => "Hola $fullName, tu pedido está pendiente. Si tiene alguna duda, comuníquese por acá.",
        ];
        $message = $messages[$newStatus] ?? "Hola $fullName, el estado de tu reserva ha sido actualizado. Más detalles en http://rutamt.test/user/orders";

        $whatsappUrl = "https://wa.me/{$phone}?text=" . urlencode($message);
        header("Location: {$whatsappUrl}");
        exit();
    }

    public function showDetails($params)
    {
        $this->ensureLoggedIn();
        $orderId = $params['id'];
        $orderModel = new Order();
        $data["title"] = "Detalles de la Orden " . $orderId;
        $data['orderDetails'] = $orderModel->getOrderDetailsById($orderId);
        $data['orderId'] = $orderId;
        $data['userInfo'] = $this->getUserInfo(); 

        return $this->view('orders/details', $data);
    }

    public function userOrders($data)
{
    $orderModel = new Order();

    
    $itemsPerPage = 5; 
    $currentPage = $_GET['page'] ?? 1;
    $offset = ($currentPage - 1) * $itemsPerPage;

    $userId = $this->getUserInfo()['id'];
    $orders = $orderModel->getOrdersByUserIdPaginated($userId, $itemsPerPage, $offset);
    $totalOrders = $orderModel->countUserOrders($userId);
    $totalPages = ceil($totalOrders / $itemsPerPage);

    $data["title"] = "Tus Ordenes " . $_SESSION['userLogged']['name'] . " " . $_SESSION['userLogged']['lastname'];    $data['orders'] = $orders;
    $data["currentPage"] = $currentPage;
    $data["totalPages"] = $totalPages;

    return $this->view('orders/user_orders', $data);
}
}
