<?php

namespace App\Models;

use Core\Session;
use stdClass;

/**
 * Benötigt kein abstract Model da es ohne der Datenbank auskommt
 */
class Basket
{
    
    public array $basket = [];

    public function __construct(null|array $data)
    {
        /**
         * Falls sich in der Session ein Basket Eintrag befindet, füre die fill function aus
         */
        if(!empty($data)){
            $data = $data;
            $this->fill($data);
        }
    }

    public function fill($data)
    {
        $this->basket = $data;
    }
    
    public function save(): bool
    {
        /**
         * Der Warenkorb wird in die Session gespeichert
         */
        Session::set("basket", $this->basket);
        return true;
    }

    /**
     * löschung des gesamten Warenkorbs
     */
    public function delete(): bool
    {
        Session::forget("basket");
        return true;
    }

    public static function get()
    {
        $data = Session::get("basket");
        $basket = new Basket($data);

        return $basket;
    }

    /**
     * Mit dieser Funktion wird ein Product mit einer bestimmten menge in den Warenkorb gelegt
     */
    public function addProduct(int $product_id, int $quantity): array
    {
        $result = false;
        $errors = [];
        $product = Product::find($product_id);
        $current_basket_item = [];


        /**
         * Überprüfung ob das Produkt vorhanden ist
         */
        if(empty($product)){
            $errors[] = "couldn't find Product";
            return [ $result, $errors ];
        }
        
        
        /**
         * befindet sich das Produkt bereits im Warenkorb
         */
        foreach($this->basket as $basket_item)
        {
            if($product_id === $basket_item->id){
                $current_basket_item = $basket_item;
                break;
            }
        }

        /**
         * Wenn das Produkt sich bereits im Warenkorb befindet dann ergenze die Menge, diese darf nicht den Lagerbestand übertrefen.
         * Sonst lege ein neues Object in den Warenkorb
         *  
         */
        if(!empty($current_basket_item) && ($quantity + $current_basket_item->quantity) <= $product->stock){

            $current_basket_item->quantity = $quantity + $current_basket_item->quantity;
            $this->save();
            $result = true;

        } elseif ($quantity <= $product->stock && empty($current_basket_item)){

            $basket_item = new stdClass;
            $basket_item->id = $product->id;
            $basket_item->name = $product->name;
            $basket_item->price = $product->price;
            $basket_item->quantity = $quantity;
            
            $this->basket[] = $basket_item;
            $this->save();
            $result = true;
        } else {
            $errors[] = "quantity is to high!";
        }   

        
        return [ $result, $errors ];
        
    }


    /**
     * Mit dieser Funktion wird ein Product mit einer bestimmten menge aus dem Warenkorb entfernt
     */
    public function removeProduct(int $product_id, int $quantity): array
    {
        $result = false;
        $errors = [];
        $product = Product::find($product_id);
        $current_basket_item = [];
        $current_basket_item_idx = "";


        /**
         * Überprüfung ob das Produkt vorhanden ist
         */
        if(empty($product)){
            $errors[] = "couldn't find Product";
            return [ $result, $errors ];
        }
        
        
        /**
         * befindet sich das Produkt bereits im Warenkorb
         */
        foreach($this->basket as $idx => $basket_item)
        {
            if($product_id === $basket_item->id){
                $current_basket_item = $basket_item;
                $current_basket_item_idx = $idx;
                break;
            }
        }

        /**
         * subtrahiere die Menge (quantity)
         * Sobald die Menge Null erreicht hat, lösche das Object aus dem Warenkorb
         *  
         */
        if( ($current_basket_item->quantity - $quantity) <= 0){

            unset($this->basket[$current_basket_item_idx]);
            $this->save();
            $result = true;

        } elseif( ($quantity - $current_basket_item->quantity) < 0) {
            
            $current_basket_item->quantity = $current_basket_item->quantity - $quantity;
            $this->save();
            $result = true;

        } else {
            $errors[] = "coudn't find Product in Basket!";
        }

        
        return [ $result, $errors ];
        
    }
}
