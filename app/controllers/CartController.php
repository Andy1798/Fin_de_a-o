<?php

namespace app\controllers;

use app\models\Product;
use app\models\Cart;
use app\models\Order;
use rutex\BaseController;

class CartController extends BaseController
{
    public function index($data)
    {
        if (!isset($_SESSION['userLogged']) && empty($_SESSION['cart'])) {
            $data["title"] = "Tu Carrito";
            $data["cart"] = [];
            return $this->view("cart/cart", $data);
        }

        $cart = $_SESSION['cart'] ?? [];

        $productModel = new Product;

        foreach ($cart as $productId => &$cartProduct) {
            $product = $productModel->findProductById($productId);

            if ($product) {

                $cartProduct['name'] = $product['name'];
                $cartProduct['price'] = $product['price'];
                $cartProduct['image'] = $product['image'];
                $cartProduct['available_stock'] = $product['quantity'];


                if ($cartProduct['quantity'] > $product['quantity']) {
                    $cartProduct['quantity'] = $product['quantity'];
                }


                $cartProduct['subtotal'] = $cartProduct['price'] * $cartProduct['quantity'];
            }
        }

        $_SESSION['cart'] = $cart;

        $data["title"] = "Tu Carrito";
        $data["cart"] = $cart;
        return $this->view("cart/cart", $data);
    }



    public function add($params)
    {
        $productId = $params['id'];
        $quantity = $_POST['quantity'] ?? 1;

        $productModel = new Product;
        $product = $productModel->findProductById($productId);

        if ($product) {
            $cartModel = new Cart;
            $price = $product['price'];
            $subtotal = $price * $quantity;

            if (isset($_SESSION['userLogged'])) {
                $userId = $_SESSION['userLogged']['id'];
                $cartModel->addProductToCart($userId, $productId, $quantity, $subtotal);

                $_SESSION['cart'] = [];
                $userCart = $cartModel->findByUserId($userId);

                foreach ($userCart as $item) {
                    $productData = $productModel->findProductById($item['product_id']);
                    $_SESSION['cart'][$item['product_id']] = [
                        'name' => $productData['name'],
                        'price' => $productData['price'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['quantity'] * $productData['price'],
                        'image' => $productData['image'],
                    ];
                }
            } else {
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId]['quantity'] += $quantity;
                } else {
                    $_SESSION['cart'][$productId] = [
                        'id' => $productId,
                        'name' => $product['name'],
                        'price' => $price,
                        'quantity' => $quantity,
                        'image' => $product['image'],
                    ];
                }

                $_SESSION['cart'][$productId]['name'] = $product['name'];
                $_SESSION['cart'][$productId]['price'] = $price;
                $_SESSION['cart'][$productId]['image'] = $product['image'];
                $_SESSION['cart'][$productId]['subtotal'] = $_SESSION['cart'][$productId]['price'] * $_SESSION['cart'][$productId]['quantity'];
            }

            $this->redirect('/cart');
        } else {
            $data['errmsg'] = "Producto no encontrado.";
            return $this->view("cart/cart", $data);
        }
    }



    public function getCount()
    {
        $count = 0;

        if (isset($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                $count += $item['quantity'];
            }
        }

        echo json_encode(['count' => $count]);
    }

    public function update($params)
    {
        $productId = $params['id'];

        $data = json_decode(file_get_contents('php://input'), true);
        $newQuantity = $data['quantity'] ?? null;


        if (!$newQuantity || !is_numeric($newQuantity) || $newQuantity <= 0) {
            echo json_encode(['success' => false, 'message' => 'Cantidad no válida']);
            return;
        }

        $productModel = new Product;
        $product = $productModel->findProductById($productId);

        if (isset($_SESSION['cart'][$productId])) {
            if ($newQuantity > $product['quantity']) {
                $newQuantity = $product['quantity'];
                $message = 'Cantidad ajustada al stock disponible';
            } else {
                $message = 'Cantidad actualizada correctamente';
            }


            $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
            $_SESSION['cart'][$productId]['subtotal'] = $_SESSION['cart'][$productId]['price'] * $newQuantity;

            echo json_encode([
                'success' => true,
                'newQuantity' => $newQuantity,
                'subtotal' => number_format($_SESSION['cart'][$productId]['subtotal'], 2),
                'message' => $message
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Producto no encontrado en el carrito.']);
        }
    }


    public function remove($params)
    {
        $productId = $params['id'];

        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);


            if (isset($_SESSION['userLogged'])) {
                $userId = $_SESSION['userLogged']['id'];
                $cartModel = new Cart();
                $cartModel->deleteProductFromCart($userId, $productId);
            }
        }

        $this->redirect('/cart');
    }


    public function clear()
    {
        unset($_SESSION['cart']);


        if (isset($_SESSION['userLogged'])) {
            $userId = $_SESSION['userLogged']['id'];
            $cartModel = new Cart();
            $cartModel->clearCart($userId);
        }

        $this->redirect('/cart');
    }

    public function finalize()
    {
        if (!isset($_SESSION['userLogged'])) {

            $this->redirect('/user/login');
        } else {
            $userId = $_SESSION['userLogged']['id'];


            $orderModel = new Order();
            $productModel = new Product();


            $orderId = $orderModel->createOrder($userId);

            if ($orderId === false) {

                echo "Error al crear el pedido.";
                return;
            }

            $cartProducts = $_SESSION['cart'] ?? [];


            foreach ($cartProducts as $productId => $cartProduct) {
                $quantity = $cartProduct['quantity'];
                $price = $cartProduct['price'];


                if (!$orderModel->addProductToOrder($orderId, $productId, $quantity, $price)) {

                    echo "Error al agregar producto al pedido.";
                }


                $productModel->decreaseStock($productId, $quantity);
            }


            $cartModel = new Cart();
            $cartModel->clearCart($userId);
            unset($_SESSION['cart']);

            $this->redirect('/user/orders');
        }
    }


}
