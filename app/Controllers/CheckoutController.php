<?php

namespace App\Controllers;

use App\Models\Basket;
use App\Models\Order;
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

    public function finish()
    {
        $order = new Order();
        $errors = $order->validateFormData();

        $basket = Basket::get();
        if (empty($basket->items)) {
            $errors[] = 'Der Warenkorb darf nicht leer sein';
        }

        if (!empty($errors)) {
            Session::set('errors', $errors);
        } else {

            $user = User::getLoggedIn();

            if (!empty($user)) {
                $order->user_id = $user->id;
            }

            $order->email = $_POST['email'];
            $order->firstname = $_POST['firstname'];
            $order->secondname = $_POST['secondname'];
            $order->phone = $_POST['phone'];
            $order->address = $_POST['address'];
            $order->city = $_POST['city'];
            $order->zip = (int) $_POST['zip'];
            $order->products = json_encode($basket->items);

            if (isset($_POST['alt_delivery']) && $_POST['alt_delivery'] === 'on') {
                $order->alt_firstname = $_POST['alt_firstname'];
                $order->alt_secondname = $_POST['alt_secondname'];
                $order->alt_phone = $_POST['alt_phone'];
                $order->alt_address = $_POST['alt_address'];
                $order->alt_city = $_POST['alt_city'];
                $order->alt_zip = (int) $_POST['alt_zip'];
            }

            $order->save();

            Session::set("lastOrder", $order);
            Redirector::redirect(BASE_URL . "/checkout/summery");
        }

        Redirector::redirect(BASE_URL . "/checkout/2");

    }

    public function summery()
    {
        /**
         * Den Warenkorb leeren, da die Bestellung durchgeführt wurde
         */
        $basket = Basket::get();
        $basket->delete();
        $order = Session::get('lastOrder');
        $order_items = json_decode($order->products);
        $total = 0;

        /**
         * Berechnung von total
         */
        foreach ($order_items as $item) {
            $total = $total + $item->price * $item->quantity;
        }

        /**
         * Bestellübersicht anzeigen
         */
        View::render('checkout/summery', [
            'order' => $order,
            'order_items' => $order_items,
            'total' => $total,
        ]);

    }
}
