<?php

namespace App\Controllers\Admin;

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
        $user = User::find($id);

        View::render('admin/user/edit', [
            'user' => $user,
        ]);
    }

    public function update(int $id)
    {
        $user = User::findOrFail($id);

        /**
         * Daten werden valiediert
         */
        $errors = $user->validateFormData('admin');

        if (!empty($errors)) {
            Session::set('errors', $errors);
        } else {

            /**
             * Einträge speichern
             */
            $user->firstname = trim($_POST['firstname']);
            $user->secondname = trim($_POST['secondname']);
            $user->email = trim($_POST['email']);
            $user->setPassword($_POST['password']);
            $user->phone = trim($_POST['phone']);
            $user->address = trim($_POST['address']);
            $user->country = trim($_POST['country']);
            $user->zip = trim($_POST['zip']);

            $user->save();

            Session::set('success', ['Erfolgreich gespeichert.']);
        }

        Redirector::redirect(BASE_URL . "/admin/user/{$user->id}/edit");

    }

    public function confirmDelete(int $id)
    {
        $user = User::findOrFail($id);

        View::render('admin/confirmDelete', [
            'type' => 'User',
            'title' => $user->email,
            'confirmUrl' => BASE_URL . "/admin/user/{$user->id}/delete",
            'abortUrl' => BASE_URL . "/admin/users",
        ]);
    }

    public function delete(int $id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        Session::set("success", ["Produkt #{$id} wurde erfolgreich gelöscht"]);
        Redirector::redirect(BASE_URL . '/admin/users');
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
