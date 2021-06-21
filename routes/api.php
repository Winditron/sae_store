<?php

use App\Controllers\Api\Admin\ApiProductController;
use App\Controllers\Api\BasketController;

return [
    /**
     * Basket routen
     */
    '/basket' => [BasketController::class, 'get'],
    '/basket/add/{id}/{quantity}' => [BasketController::class, 'add'],
    '/basket/remove/{id}/{quantity}' => [BasketController::class, 'remove'],
    '/basket/set/{id}/{quantity}' => [BasketController::class, 'set'],

    /**
     * Admin Picture routen
     */
    '/admin/product/{productid}/picture/{pictureid}/unbind' => [ApiProductController::class, 'unbindPicture'], # Bilder Vererbindung zu einem Product aufheben
];
