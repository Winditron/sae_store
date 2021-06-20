<?php

namespace App\Controllers\Admin;

use App\Models\User;
use Core\Helpers\Redirector;
use Core\Middlewares\AuthMiddleware;
use Core\Session;
use Core\View;

class UserController
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
            $user->zip = trim($_POST['zip']);

            /**
             * Bearbeiten wir uns gerade nicht selber?
             */
            if (User::getLoggedIn()->id !== $user->id) {
                /**
                 * Wenn wir uns nicht selbst bearbeiten, dann prüfen wir, ob die is_admin Checkbox geklickt worden ist,
                 * und wenn ja, dann vergeben wir Admin Berechtigungen oder entfernen sie, wenn die Checkbox nicht
                 * ausgewählt war.
                 */
                if (isset($_POST['is_admin']) && $_POST['is_admin'] === 'on') {
                    $user->is_admin = true;
                } else {
                    $user->is_admin = false;
                }
            }

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

}
