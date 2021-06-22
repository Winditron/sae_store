<?php

use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\OrderController as AdminOrderController;
use App\Controllers\Admin\ProductController as AdminProductController;
use App\Controllers\Admin\UserController as AdminUserController;
use App\Controllers\AuthController;
use App\Controllers\BasketController;
use App\Controllers\CheckoutController;
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
    '/basket' => [BasketController::class, 'index'], #Warenkorbübersicht

    /**
     * Checkout routen
     */
    '/checkout/1' => [CheckoutController::class, 'loginOrGuest'], #Step 1 Anmelden oder als Gast
    '/checkout/1/login' => [CheckoutController::class, 'loginUser'], #Step 1.1 User anmelden
    '/checkout/2' => [CheckoutController::class, 'checkoutForm'], #step 2 benötigte Lieferdaten
    '/checkout/3' => [CheckoutController::class, 'finish'], #step validate and save
    '/checkout/summery' => [CheckoutController::class, 'summery'], #step 3 Bestellübersicht

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

    /**
     * Admin Order Bestellungen routen
     */
    '/admin/orders' => [AdminOrderController::class, 'index'], #  Auflistung aller Bestellungen
    '/admin/order/{id}/edit' => [AdminOrderController::class, 'edit'], # Bearbeitungsformular für eine Bestellung
    '/admin/order/{id}/edit/update' => [AdminOrderController::class, 'update'], # Neue Einträge speichern

];
