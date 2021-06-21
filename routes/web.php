<?php

use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\ProductController as AdminProductController;
use App\Controllers\Admin\UserController as AdminUserController;
use App\Controllers\AuthController;
use App\Controllers\BasketController;
use App\Controllers\ProductController;
use App\Controllers\ProfileController;

return [

    /**
     * Shop/Product routen
     */
    '/Shop' => [ProductController::class, 'index'], # Auflistung aller Produkte
    '/Shop/{slug}' => [ProductController::class, 'show'], #Produktübersicht

    /**
     * Warenkorb (Basket) routen
     */
    '/basket' => [BasketController::class, 'index'], #Produktübersicht

    /**
     * login & signup routen
     */
    '/login' => [AuthController::class, 'loginForm'], #loginfromular
    '/login/finish' => [AuthController::class, 'login'], #login prozess
    '/logout' => [AuthController::class, 'logout'], #logout prozess
    '/sign-up' => [AuthController::class, 'signupForm'], # signup formular
    '/sign-up/finish' => [AuthController::class, 'signup'], # signup prozess

    /**
     * User Profil
     */
    '/profile/dashboard' => [ProfileController::class, 'dashboard'], # startroute eines eingeloggten USers
    '/profile/edit' => [ProfileController::class, 'edit'], # Bearbeitungsformular für ein Profil
    '/profile/edit/update' => [ProfileController::class, 'update'], # Neue Einträge speichern
    '/profile/orders' => [ProfileController::class, 'orders'], # Auflistung aller Bestellungen

    /**
     * Admin routen
     */
    '/admin/dashboard' => [AdminController::class, 'dashboard'], # startroute des Adminbereichs
    /**
     * Admin Product routen
     */
    '/admin/products' => [AdminProductController::class, 'index'], #  Auflistung aller Produkte
    '/admin/product/{id}/delete/confirm' => [AdminProductController::class, 'confirmDelete'], #  Bestetigung des löschen eines Produkts
    '/admin/product/{id}/delete' => [AdminProductController::class, 'delete'], #  Löschen eines Produkts (Soft delete)
    '/admin/product/{id}/edit' => [AdminProductController::class, 'edit'], # Bearbeitungsformular für Produkte
    '/admin/product/{id}/edit/update' => [AdminProductController::class, 'update'], # Neue Einträge speichern
    '/admin/product/{id}/pictures/selection' => [AdminProductController::class, 'pictureSelection'], # Bilderauswahl
    '/admin/product/{id}/pictures/bind' => [AdminProductController::class, 'bindPictures'], # Ausgeweählte Bilder hinzufügen
    /**
     * Admin User routen
     */
    '/admin/users' => [AdminUserController::class, 'index'], #  Auflistung aller Users
    '/admin/user/{id}/delete/confirm' => [AdminUserController::class, 'confirmDelete'], #  Bestetigung des löschen eines Users
    '/admin/user/{id}/delete' => [AdminUserController::class, 'delete'], #  Löschen eines Users (Soft delete)
    '/admin/user/{id}/edit' => [AdminUserController::class, 'edit'], # Bearbeitungsformular für ein UserKonto
    '/admin/user/{id}/edit/update' => [AdminUserController::class, 'update'], # Neue Einträge speichern

];
