<?php

use App\Controllers\Admin\ProductController as AdminProductController;
use App\Controllers\AuthController;
use App\Controllers\ProductController;

return [

    /**
     * Shop/Product routen
     */
    '/Shop' => [ProductController::class, 'index'], # Auflistung aller Produkte
    '/Shop/{slug}' => [ProductController::class, 'show'], #Produktübersicht

    /**
     * login & signup routen
     */
    '/login' => [AuthController::class, 'loginForm'], #loginfromular
    '/login/finish' => [AuthController::class, 'login'], #login prozess
    '/logout' => [AuthController::class, 'logout'], #logout prozess
    '/sign-up' => [AuthController::class, 'signupForm'], # signup formular
    '/sign-up/finish' => [AuthController::class, 'signup'], # signup prozess

    /**
     * Admin routen
     */

    /**
     * Admin Product routen
     */
    '/admin/products' => [AdminProductController::class, 'index'], #  Auflistung aller Produkte
    '/admin/product/{id}/edit' => [AdminProductController::class, 'edit'], # Bearbeitungsformular für Produkte
    '/admin/product/{id}/edit/update' => [AdminProductController::class, 'update'], # Bearbeitungsformular für Produkte

];
