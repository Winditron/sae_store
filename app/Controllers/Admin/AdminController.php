<?php

namespace App\Controllers\Admin;

use Core\View;

class AdminController
{
    public function dashboard()
    {
        View::render("admin/dashboard", []);
    }
}
