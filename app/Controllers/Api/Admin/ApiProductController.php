<?php

namespace App\Controllers\Api\Admin;

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

    public function unbindPicture()
    {
        echo "hallo";
    }

}
