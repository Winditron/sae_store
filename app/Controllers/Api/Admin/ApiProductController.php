<?php

namespace App\Controllers\Api\Admin;

use App\Models\Product;
use Core\ApiResponse;
use Core\Middlewares\AuthMiddleware;

class ApiProductController
{
    public function __construct()
    {
        /**
         * Eingeloggter User muss ein Admin sein um functionen aufrufen zu können
         */
        AuthMiddleware::APIloggedInAdminOrFail();
    }

    public function unbindPicture(int $productid, int $pictureid)
    {
        $product = Product::find($productid);

        if (empty($product)) {
            ApiResponse::json("could not find Product", 400);
            exit;
        }

        if (!$product->unbindPicture($pictureid)) {
            ApiResponse::json("could not unbind Picture", 400);
            exit;
        }
    }
}
