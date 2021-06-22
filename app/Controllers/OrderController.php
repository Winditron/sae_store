<?php

namespace App\Controllers;

use App\Models\Order;
use App\Models\User;
use Core\Helpers\Redirector;
use Core\Session;
use Core\View;

class OrderController
{

    public function index()
    {

        $user = User::getLoggedIn();

        $orders = Order::findByUser($user->id);

        View::render('profile/order/index', [
            'orders' => $orders,
        ]);
    }

    public function show(int $id)
    {
        $user = User::getLoggedIn();

        $order = Order::findByUser($user->id, $id);
        $order_items = json_decode($order->products);

        var_dump($order->status);

        View::render('profile/order/show', [
            'order' => $order,
            'order_items' => $order_items,
        ]);
    }

    public function update(int $id)
    {

        $errors = [];

        $user = User::getLoggedIn();
        $order = Order::findByUser($user->id, $id);

        if (empty($order)) {
            $errors[] = "Bestellung konnte nicht gefunden werden.";
            Session::set('errors', $errors);
            Redirector::redirect(BASE_URL . "/profile/order/{$order->id}/show");
        }

        /**
         * Daten werden valiediert
         */
        if (isset($_POST['status']) && !empty($_POST['status'])) {

            /**
             * Hier wird jeder mögliche Status wert durchgegangen und nachgeschaut, ob dieser mit dem übergebenen Wert übereinstimmt
             */
            $validStatusValues = $order->statusValues();

            $valid = false;

            foreach ($validStatusValues as $validValues) {
                if ($validValues === $_POST['status']) {
                    $valid = true;
                    break;
                }
            }

            if (!$valid) {
                $errors[] = "Der Status ist kein gültiger Wert.";
            }

        }

        if (!empty($errors)) {
            Session::set('errors', $errors);
        } else {

            $order->status = $_POST['status'];

            if (!$order->save()) {
                Session::set('errors', ['Stornierung konnte nicht beantragt werden.']);
                Redirector::redirect(BASE_URL . "/profile/order/{$order->id}/show");
            }

            Session::set('success', ['Stornierung wurde beantragt.']);

        }

        Redirector::redirect(BASE_URL . "/profile/order/{$order->id}/show");

    }

}
