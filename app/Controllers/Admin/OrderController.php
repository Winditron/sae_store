<?php

namespace App\Controllers\Admin;

use App\Models\Order;
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
        $orders = Order::all();

        View::render('admin/order/index', [
            'orders' => $orders,
        ]);
    }

    public function edit(int $id)
    {
        $order = Order::find($id);
        $order_items = json_decode($order->products);
        $total = 0;

        /**
         * Berechnung von total
         */
        foreach ($order_items as $item) {
            $total = $total + $item->price * $item->quantity;
        }

        View::render('admin/order/edit', [
            'order' => $order,
            'order_items' => $order_items,
            'total' => $total,
        ]);
    }

    public function update(int $id)
    {

        $errors = [];

        $order = Order::find($id);

        if (empty($order)) {
            $errors[] = "Bestellung konnte nicht gefunden werden.";
            Session::set('errors', $errors);
            Redirector::redirect(BASE_URL . "/admin/order/{$order->id}/edit");
        }

        /**
         * Daten werden valiediert
         */
        $errors = $order->validateFormData();

        if (!empty($errors)) {
            Session::set('errors', $errors);
        } else {

            $order->email = $_POST['email'];
            $order->firstname = $_POST['firstname'];
            $order->secondname = $_POST['secondname'];
            $order->phone = $_POST['phone'];
            $order->address = $_POST['address'];
            $order->city = $_POST['city'];
            $order->zip = (int) $_POST['zip'];
            $order->status = $_POST['status'];

            if (isset($_POST['alt_delivery']) && $_POST['alt_delivery'] === 'on') {

                $order->alt_firstname = $_POST['alt_firstname'];
                $order->alt_secondname = $_POST['alt_secondname'];
                $order->alt_phone = $_POST['alt_phone'];
                $order->alt_address = $_POST['alt_address'];
                $order->alt_city = $_POST['alt_city'];
                $order->alt_zip = (int) $_POST['alt_zip'];

            } else {

                $order->alt_firstname = null;
                $order->alt_secondname = null;
                $order->alt_phone = null;
                $order->alt_address = null;
                $order->alt_city = null;
                $order->alt_zip = null;

            }

            if (!$order->save()) {
                Session::set('errors', ['Konnt nicht gespeichert werden.']);
                Redirector::redirect(BASE_URL . "/admin/order/{$order->id}/edit");
            }

            Session::set('success', ['Erfolgreich gespeichert.']);

        }

        Redirector::redirect(BASE_URL . "/admin/order/{$order->id}/edit");

    }

}
