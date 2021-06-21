<?php

namespace App\Controllers;

use App\Models\Basket;
use Core\View;

class BasketController
{
    public function index()
    {
        $basket = Basket::get();

        View::render("basket/index", [
            'basket' => $basket,
        ]);
    }
}
