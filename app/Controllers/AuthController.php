<?php

namespace App\Controllers;

use App\Models\Basket;
use App\Models\User;
use Core\Helpers\Redirector;
use Core\Session;
use Core\View;

class AuthController
{

    public function loginForm()
    {
        if (User::isLoggedIn()) {
            Redirector::redirect(BASE_URL);
        }

        View::render('authentication/login');
    }

    public function login()
    {
        $errors = [];

        $user = User::findByEmail($_POST['email']);

        if (empty($user) || !$user->checkPassword($_POST['password'])) {
            $errors[] = 'Das Passwort oder die Email ist nicht korrekt!';
        } else {
            $remember = false;

            if (isset($_POST['remember'])) {
                $remember = true;
            }

            if ($user->is_admin) {
                $user->login(BASE_URL . '/admin/dashboard', $remember);
            } else {
                $user->login(BASE_URL . '/Shop', $remember);
            }
        }

        Session::set('errors', $errors);
        Redirector::redirect(BASE_URL . '/login');
    }

    public function logout()
    {
        /**
         * Warenkorb entleeren beim Ausloggen
         */
        $basket = Basket::get();
        $basket->delete();

        User::logout(BASE_URL);
    }

    public function signupForm()
    {
        View::render('authentication/signup');
    }

    public function signup()
    {
        $user = new User();

        $errors = $user->validateFormData('signup');

        if (!empty(User::findByEmail($_POST['email']))) {
            $errors[] = 'Die angegebene Email Adresse wird bereitz von einem Konto benutzt!';
        }

        if (!empty($errors)) {
            Session::set('errors', $errors);
            Redirector::redirect(BASE_URL . '/sign-up');
        }

        $user->firstname = trim($_POST['firstname']);
        $user->secondname = trim($_POST['secondname']);
        $user->email = trim($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->phone = trim($_POST['phone']);
        $user->address = trim($_POST['address']);
        $user->city = trim($_POST['city']);
        $user->zip = trim($_POST['zip']);

        if ($user->save()) {
            $success = ['Das Konto wurde erfolgreich angelegt!'];
            Session::set('success', $success);
            Redirector::redirect(BASE_URL . '/login');
        } else {
            $errors[] = 'Beim Anlegen des Kontos ist etwas schiefgelaufen!';
            Session::set('errors', $errors);
            Redirector::redirect(BASE_URL . '/sign-up');
        }
    }

}
