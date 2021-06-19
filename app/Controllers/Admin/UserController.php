<?php

namespace App\Controllers\Admin;

use App\Models\Category;
use App\Models\Picture;
use App\Models\Product;
use App\Models\User;
use Core\Helpers\Redirector;
use Core\Session;
use Core\View;

class UserController
{
    public function index()
    {
        $users = User::all();

        View::render('admin/user/index', [
            'users' => $users,
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

    public function confirmDelete(int $id)
    {
        $product = Product::findOrFail($id);

        View::render('admin/confirmDelete', [
            'type' => 'Produkt',
            'title' => $product->name,
            'confirmUrl' => BASE_URL . "/admin/product/{$product->id}/delete",
            'abortUrl' => BASE_URL . "/admin/products",
        ]);
    }

    public function delete(int $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        Session::set("success", ["Produkt #{$id} wurde erfolgreich gelöscht"]);
        Redirector::redirect(BASE_URL . '/admin/products');
    }

    public function pictureSelection(int $id)
    {
        $product = Product::findOrFail($id);

        $pictures = Picture::allNotBindedToProduct($id);

        View::render('picture/selection', [
            'type' => 'Produkt',
            'title' => $product->name,
            'pictures' => $pictures,
            'confirmUrl' => BASE_URL . "/admin/product/{$product->id}/pictures/bind",
            'abortUrl' => BASE_URL . "/admin/product/{$product->id}/edit",

        ]);

    }

    public function bindPictures(int $id)
    {
        $product = Product::findOrFail($id);

        $picture_ids = [];

        foreach ($_POST["marked-pictures"] as $picture_id => $checked) {
            $picture_ids[] = $picture_id;
        }

        [$result, $errors] = $product->bindPictures($picture_ids);

        if (!empty($errors)) {
            Session::set("errors", $errors);
        }

        if ($result) {
            Session::set("success", ['Bilder wurden erfolgreich verknüpft!']);
        } else {
            $errors[] = "Es konnten keine Bilder verknüpft werden!";
            Session::set("errors", $errors);
        }

        #Redirector::redirect(BASE_URL . "/admin/product/{$id}/edit");
    }

}
