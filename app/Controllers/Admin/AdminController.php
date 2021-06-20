<?php

namespace App\Controllers\Admin;

use Core\Middlewares\AuthMiddleware;
use Core\View;

class AdminController
{

    public function __construct()
    {
        /**
         * Eingeloggter User muss ein Admin sein um functionen aufrufen zu können
         */
        AuthMiddleware::isAdminOrFail();
    }

    public function dashboard()
    {
        View::render("admin/dashboard", []);
    }
}
