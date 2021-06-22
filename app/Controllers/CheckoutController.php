<?php

namespace App\Controllers;

use App\Models\Basket;
use App\Models\User;
use Core\Helpers\Redirector;
use Core\Session;
use Core\View;

class CheckoutController
{

    public function __construct()
    {
        /**
         * Um eine Function hier nutzen zu können darf der Warenkorb nicht leer sein
         */
        $basket = Basket::get();

        if (empty($basket->items)) {
            Redirector::redirect(BASE_URL . '/basket');
        }
    }

    public function loginOrGuest()
    {
        /**
         * Falls ein user eingloggt ist übespringe diesen Step
         */
        if (User::isLoggedIn()) {
            Redirector::redirect(BASE_URL . '/checkout/2');
        }

        View::render('checkout/loginOrGuest', []);
    }

    public function loginUser()
    {

        /**
         * Falls sich ein User einloggen möchte
         */
        if (!empty($_POST)) {

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
                    $user->login(BASE_URL . '/checkout/2', $remember);
                } else {
                    $user->login(BASE_URL . '/checkout/2', $remember);
                }
            }

            Session::set('errors', $errors);
            Redirector::redirect(BASE_URL . '/checkout/1');
        }
    }

    public function checkoutForm()
    {
        $user = User::getLoggedIn();

        View::render('checkout/checkoutForm', [
            'user' => $user,
        ]);

    }

    public function validateForm()
    {

    }
}
