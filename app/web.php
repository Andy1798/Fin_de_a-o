<?php

use rutex\Route;
use app\controllers\HomeController;
use app\controllers\UserController;
use app\controllers\ProductController;
use app\controllers\CategoryController;
use app\controllers\BrandController;
use app\controllers\CatalogController;
use app\controllers\SliderController;
use app\controllers\AdminHomeController;

Route::get("/", [HomeController::class, "index"]);
Route::get("/admin", "admin");
Route::get("/viewHome/homecontrol", "homeControl");
Route::get("/catalog", [CatalogController::class, "index"]);

// USER FORM
Route::get("/user/login", [UserController::class, "login"]);
Route::get("/user/logout", [UserController::class, "logout"]);
Route::get("/user/create", [UserController::class, "create"]);

// Restablecimiento de contraseña
Route::get("/user/forgot-password", [UserController::class, "forgotPassword"]); // Formulario de "Olvidé mi clave"
Route::post("/user/send-reset-email", [UserController::class, "sendResetEmail"]); // Procesa el envío del correo de restablecimiento
Route::get("/user/reset-password", [UserController::class, "resetPassword"]); // Formulario para restablecer la clave
Route::post("/user/update-password", [UserController::class, "updatePassword"]); // Procesa la actualización de la clave

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

// Rutas para categorías
Route::get("/category/create", [CategoryController::class, "index"]);
Route::post("/category/store", [CategoryController::class, "store"]);

// Rutas para marcas
Route::get("/brand/create", [BrandController::class, "index"]);
Route::post("/brand/store", [BrandController::class, "store"]);
// CATALOGO
Route::get("/catalog/category/:id", [CatalogController::class, "filterByCategory"]);
Route::get("/catalog/search", [CatalogController::class, "search"]);
//VIEW HOME
Route::get('/admin/slider', [SliderController::class, 'index']);
Route::post('/admin/slider/store', [SliderController::class, 'store']);
Route::post('/admin/slider/delete/:id', [SliderController::class, 'delete']);
Route::get('/admin/homecontrol', [AdminHomeController::class, 'homeControl']);

//CATALOGO
Route::get('/catalog/product/:id', [CatalogController::class, 'view_product']);






Route::listen();
