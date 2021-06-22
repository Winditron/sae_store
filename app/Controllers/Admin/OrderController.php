<?php

namespace App\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;
use Core\Helpers\Redirector;
use Core\Middlewares\AuthMiddleware;
use Core\Session;
use Core\View;

class OrderController
{

    public function __construct()
    {
        /**
         * Eingeloggter User muss ein Admin sein um functionen aufrufen zu können
         */
        AuthMiddleware::isAdminOrFail();
    }

    public function index()
    {
        $products = Product::all();

        View::render('admin/product/index', [
            'products' => $products,
        ]);
    }

    public function edit(int $id)
    {
        $product = Product::find($id);
        $categories = Category::all();

        View::render('admin/product/edit', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function update(int $id)
    {

        $errors = [];

        $product = Product::find($id);

        if (empty($product)) {
            $errors[] = "Produkt konnte nicht gefunden werden.";
            Session::set('errors', $errors);
            Redirector::redirect(BASE_URL . "/admin/product/{$product->id}/edit");
        }

        /**
         * Daten werden valiediert
         */
        $errors = $product->validateFormData();

        if (!empty($errors)) {
            Session::set('errors', $errors);
        } else {

            /**
             * Einträge speichern
             */
            $product->name = trim($_POST['name']);
            $product->slug = trim($_POST['slug']);
            $product->highlight_picture = trim((int) $_POST['highlight-img']);
            $product->price = trim((float) $_POST['price']);
            $product->category = trim((int) $_POST['category']);
            $product->size = trim((int) $_POST['size']);
            $product->stock = trim((int) $_POST['stock']);
            $product->description = trim($_POST['description']);
            $product->watering = trim($_POST['watering']);
            $product->sun_location = trim($_POST['sun_location']);

            $product->save();

            /**
             * Verknüpfungen zu den Bilden löschen
             */
            $delete_pictures = [];
            foreach ($_POST['delete-imgs'] as $picture_id => $on) {
                $delete_pictures[] = $picture_id;
            }

            $product->unbindPictures($delete_pictures);

            Session::set('success', ['Erfolgreich gespeichert.']);
        }

        Redirector::redirect(BASE_URL . "/admin/product/{$product->id}/edit");

    }

}
