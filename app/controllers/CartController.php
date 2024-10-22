<?php

namespace app\controllers;

use app\models\Product;
use rutex\BaseController;

class CartController extends BaseController
{
    public function index($data)
    {
        // Mostrar los productos en el carrito
        $cart = $_SESSION['cart'] ?? [];

        $data["title"] = "Tu Carrito";
        $data["cart"] = $cart;
        return $this->view("cart/index", $data);
    }

    public function add($params)
    {
        $productId = $params['id'];
        $quantity = $_POST['quantity'] ?? 1;

        // Buscar el producto por ID
        $productModel = new Product;
        $product = $productModel->findProductById($productId);

        if ($product) {
            // Verificar si el producto ya está en el carrito
            if (isset($_SESSION['cart'][$productId])) {
                // Si el producto ya está en el carrito, actualiza la cantidad y el subtotal
                $_SESSION['cart'][$productId]['quantity'] += $quantity;
                $_SESSION['cart'][$productId]['subtotal'] = $_SESSION['cart'][$productId]['price'] * $_SESSION['cart'][$productId]['quantity'];
            } else {
                // Agregar nuevo producto al carrito
                $_SESSION['cart'][$productId] = [
                    'id' => $productId,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity,
                    'subtotal' => $product['price'] * $quantity,
                ];
            }

            // Redirigir al carrito o devolver una respuesta
            $this->redirect('/cart');
        } else {
            $data['errmsg'] = "Producto no encontrado.";
            return $this->view("cart/index", $data);
        }
    }


    public function update($params)
    {
        $productId = $params['id'];

        // Depuración adicional para ver el contenido recibido en el servidor
        $data = json_decode(file_get_contents('php://input'), true);
        var_dump($data); // Ver qué llega al servidor
        $newQuantity = $data['quantity'] ?? null;

        if (!$newQuantity) {
            echo json_encode(['success' => false, 'message' => 'Cantidad no recibida']);
            return;
        }

        if (isset($_SESSION['cart'][$productId])) {
            // Actualizar la cantidad y el subtotal
            $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
            $_SESSION['cart'][$productId]['subtotal'] = $_SESSION['cart'][$productId]['price'] * $newQuantity;

            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Producto no encontrado en el carrito.']);
        }
    }



    public function remove($params)
    {
        $productId = $params['id'];

        if (isset($_SESSION['cart'][$productId])) {
            // Eliminar el producto del carrito
            unset($_SESSION['cart'][$productId]);
        }

        // Redirigir al carrito
        $this->redirect('/cart');
    }

    public function clear()
    {
        // Vaciar el carrito
        unset($_SESSION['cart']);

        // Redirigir al carrito
        $this->redirect('/cart');
    }

    public function finalize()
    {
        if (!isset($_SESSION['userLogged'])) {
            // Si el usuario no está logueado, redirigir al login
            $this->redirect('/user/login');
        } else {
            // Aquí podríamos manejar la lógica para guardar el pedido en la base de datos
            // Guardar los productos del carrito en un pedido
            // Vaciar el carrito después de finalizar el pedido

            // Redirigir al listado de pedidos
            $this->redirect('/orders');
        }
    }
}
