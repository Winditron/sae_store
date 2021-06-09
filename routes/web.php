<?php

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
];
