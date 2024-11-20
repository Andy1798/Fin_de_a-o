<?php

use rutex\Route;
use app\controllers\HomeController;
use app\controllers\UserController;
use app\controllers\ProductController;
use app\controllers\CategoryController;
use app\controllers\BrandController;
use app\controllers\CatalogController;
use app\controllers\SliderController;
use app\controllers\CartController;
use app\controllers\OrderController;
use app\controllers\EarningsController;

Route::get("/", [HomeController::class, "index"]);
Route::get("/catalog", [CatalogController::class, "index"]);

// USER FORM
Route::get("/user/login", [UserController::class, "login"]);
Route::get("/user/logout", [UserController::class, "logout"]);
Route::get("/user/create", [UserController::class, "create"]);

// Restablecimiento de contraseña
Route::get("/user/forgot-password", [UserController::class, "forgotPassword"]); // Formulario de "Olvidé mi clave"
Route::post("/user/send-reset-code", [UserController::class, "sendResetCode"]); // Procesa el envío del código al correo
Route::get("/user/enter-code", [UserController::class, "verifyCode"]);          // Formulario para ingresar el código
Route::post("/user/verify-code", [UserController::class, "verifyCode"]);        // Procesa la validación del código
Route::get("/user/reset-password", [UserController::class, "resetPassword"]);  // Formulario para restablecer la clave
Route::post("/user/update-password-with-code", [UserController::class, "updatePasswordWithCode"]); // Procesa la actualización de la clave

// USER ACCIÓN
Route::post("/user/login", [UserController::class, "check"]);
Route::post("/user/store", [UserController::class, "store"]);

// Rutas para productos
Route::get("/product", [ProductController::class, "index"]); // Lista de productos
Route::get("/product/create", [ProductController::class, "create"]); // Formulario para crear producto
Route::post("/product/store", [ProductController::class, "store"]); // Guardar nuevo producto
Route::get("/product/edit/:id", [ProductController::class, "edit"]); // Formulario para editar producto
Route::post("/product/update/:id", [ProductController::class, "update"]); // Actualizar producto
Route::post("/product/delete/:id", [ProductController::class, "delete"]); // Eliminar producto
Route::post('/product/togglePublished/:id', [ProductController::class, 'togglePublished']);
Route::post('/product/toggleFeatured/:id', [ProductController::class, 'toggleFeatured']);
Route::get('/product/buscar', [ProductController::class, 'buscar']); // Búsqueda de productos

// Rutas para categorías
Route::get("/category/create", [CategoryController::class, "index"]);
Route::post("/category/store", [CategoryController::class, "store"]);

// Rutas para marcas
Route::get("/brand/create", [BrandController::class, "index"]);
Route::post("/brand/store", [BrandController::class, "store"]);

// CATALOGO
Route::get("/catalog/category/:id", [CatalogController::class, "filterByCategory"]);
Route::get("/catalog/search", [CatalogController::class, "search"]);

// VIEW HOME
Route::get('/admin/slider', [SliderController::class, 'index']);
Route::post('/admin/slider/store', [SliderController::class, 'store']);
Route::post('/admin/slider/delete/:id', [SliderController::class, 'delete']);

// CATALOGO
Route::get('/catalog/product/:id', [CatalogController::class, 'view_product']);


// Rutas para el carrito de compras
Route::get('/cart', [CartController::class, 'index']);            // Ver carrito
Route::post('/cart/add/:id', [CartController::class, 'add']);      // Añadir producto al carrito
Route::get('/cart/getCount', [CartController::class, 'getCount']);
Route::post('/cart/update/:id', [CartController::class, 'update']); // Actualizar cantidad de producto en el carrito
Route::post('/cart/remove/:id', [CartController::class, 'remove']); // Eliminar producto del carrito
Route::post('/cart/clear', [CartController::class, 'clear']);       // Vaciar el carrito
Route::post('/cart/finalize', [CartController::class, 'finalize']); // Finalizar pedido

// Rutas para órdenes
Route::get('/admin', [OrderController::class, 'index']);            // Ver todas las órdenes (admin)
Route::post('/orders/changeStatus/:id', [OrderController::class, 'changeStatus']); // Cambiar estado de la orden
Route::get('/user/orders', [OrderController::class, 'userOrders']);  // Ver órdenes del usuario
Route::get('/orders/showDetails/:id', [OrderController::class, 'showDetails']);

// Rutas para ganancias
Route::get('/earnings', [EarningsController::class, 'index']);       // Ver reporte de ganancias (admin)
Route::post('/earnings/filter', [EarningsController::class, 'filterByDate']); // Filtrar ganancias por fecha

Route::listen();
