<?php

return [
    /**
     * Basket routen
     */
    #'/basket/add/{id}' => [],

    /**
     * Admin Picture routen
     */
    '/admin/product/{product_id}/unbind' => [AdminProductController::class => 'unbindPicture'], # Bilder Vererbindung zu einem Product aufheben
];
