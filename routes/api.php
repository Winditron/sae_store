<?php

use App\Controllers\Api\Admin\ApiProductController;

return [
    /**
     * Basket routen
     */
    #'/basket/add/{id}' => [],

    /**
     * Admin Picture routen
     */
    '/admin/product/{productid}/picture/{pictureid}/unbind' => [ApiProductController::class, 'unbindPicture'], # Bilder Vererbindung zu einem Product aufheben
];
