<?php

namespace Core\Helpers;

trait Formatter
{
    /**
     * formatiert den Preis mit kommastellen
     */
    public static function formatPrice(int $price): string
    {
        return "&euro; " . number_format($price, 2, ",", ".");
    }

}
