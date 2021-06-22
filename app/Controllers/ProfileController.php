<?php

namespace App\Controllers;

use App\Models\User;
use Core\Helpers\Redirector;
use Core\Session;
use Core\View;

class ProfileController
{
    public function dashboard()
    {
        View::render("profile/dashboard", []);
    }

    public function edit()
    {
        $user = User::getLoggedIn();

        View::render('profile/edit', [
            'user' => $user,
        ]);
    }

    public function update()
    {
        $user = User::getLoggedIn();

        /**
         * Daten werden valiediert
         */
        $errors = $user->validateFormData('profile');

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
            $user->city = trim($_POST['city']);
            $user->zip = trim($_POST['zip']);

            $user->save();

            Session::set('success', ['Erfolgreich gespeichert.']);
        }

        Redirector::redirect(BASE_URL . "/profile/edit");

    }

}
