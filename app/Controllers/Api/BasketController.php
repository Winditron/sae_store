<?php

namespace App\Controllers\Api;

use App\Models\Basket;
use Core\ApiResponse;

/**
 * Mann muss nicht eingeloggt sein um im Warekorb Aktionen zu tätigen
 */
class BasketController
{

    public function get()
    {
        $basket = Basket::get();

        return ApiResponse::json($basket->items);
    }

    public function add(int $id, int $quantity)
    {
        $basket = Basket::get();

        $result = $basket->addProduct($id, $quantity);

        return ApiResponse::json($result);
    }

    public function remove(int $id, int $quantity)
    {
        $basket = Basket::get();

        $result = $basket->removeProduct($id, $quantity);

        return ApiResponse::json($result);
    }

    public function set(int $id, int $quantity)
    {
        $basket = Basket::get();

        $result = $basket->setProduct($id, $quantity);

        return ApiResponse::json($result);
    }

}
