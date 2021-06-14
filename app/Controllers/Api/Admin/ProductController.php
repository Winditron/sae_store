<?php

namespace App\Controllers\Api\Admin;

class ProductController
{
    public function __construct()
    {
        /**
         * Eingeloggter User muss ein Admin sein um functionen aufrufen zu können
         */
        #AuthMiddleware::APIloggedInAdminOrFail();
    }

    public function unbindPicture($product_id)
    {
        var_dump($product_id);
        echo "test";

    }

}
