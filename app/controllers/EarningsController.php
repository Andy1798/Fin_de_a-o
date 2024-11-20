<?php
namespace app\controllers;

use app\models\Order;
use rutex\BaseController;

class EarningsController extends BaseController
{
    public function index($data)
    {
        $orderModel = new Order();
        $data["title"] = "Mis Ganancias";

        $completedOrders = $orderModel->getOrdersByStatus('Finalizado');
        $data['completedOrders'] = $completedOrders;

        $data['grandTotal'] = array_sum(array_column($completedOrders, 'total'));

        return $this->view('earnings/earnings', $data);
    }

    public function filterByDate($data)
    {
        if (isset($_POST['start_date']) || isset($_POST['end_date'])) {
            $startDate = $_POST['start_date'] ?? null;
            $endDate = $_POST['end_date'] ?? null;
            $orderModel = new Order();
            $data["title"] = "Ganancias desde " . $startDate . " hasta " . $endDate;
            error_log("startDate: " . $startDate);
            error_log("endDate: " . $endDate);
    
            $completedOrders = $orderModel->getOrdersByDate($startDate, $endDate);
            
            error_log("Número de órdenes completadas: " . count($completedOrders));
            
            $data['completedOrders'] = $completedOrders;
    
            $data['grandTotal'] = array_sum(array_column($completedOrders, 'total'));
        } else {
            $this->redirect('/earnings');
        }
    
        return $this->view('earnings/earnings', $data);
    }
}
    