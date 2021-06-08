<?php

use App\Controllers\ProductController;

return [

    /**
     * Shop/Product routen
     */
    '/Shop' => [ProductController::class, 'index'],
    '/Shop/{slug}' => [ProductController::class, 'show'],

];
