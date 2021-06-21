<?php

namespace App\Models;

use Core\Session;
use Core\Traits\HasPrice;
use stdClass;

/**
 * Benötigt kein abstract Model, da es ohne der Datenbank auskommt
 * Der Warenkorb wird nur in der Session gespeichert
 */
class Basket
{
    
    public array $items = [];

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
        $this->items = $data;
    }
    
    public function save(): bool
    {
        /**
         * Der Warenkorb wird in die Session gespeichert
         */
        Session::set("basket", $this->items);
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
        $result = ['success' => false, 'errors' => [], 'response' => null];
        $product = Product::find($product_id);
        $current_basket_item = [];


        /**
         * Überprüfung ob das Produkt vorhanden ist
         */
        if(empty($product)){
            $result['errors'][] = "couldn't find Product";
            return $result;
        }
        
        
        /**
         * befindet sich das Produkt bereits im Warenkorb
         */
        foreach($this->items as $basket_item)
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
            $result['success'] = true;
            $result['response'] = $current_basket_item;


        } elseif ($quantity <= $product->stock && empty($current_basket_item)){

            $basket_item = new stdClass;
            $basket_item->id = $product->id;
            $basket_item->name = $product->name;
            $basket_item->price = $product->price;
            $basket_item->quantity = $quantity;
            
            $this->items[] = $basket_item;
            $this->save();
            $result['success'] = true;
            $result['response'] = $current_basket_item;

        } else {
            $result['errors'][] = "quantity is to high!";
        }   

        
        return $result;
        
    }


    /**
     * Mit dieser Funktion wird ein Product mit einer bestimmten menge aus dem Warenkorb entfernt
     */
    public function removeProduct(int $product_id, int $quantity): array
    {
        $result = ['success' => false, 'errors' => null, 'response' => null];
        $errors = [];
        $product = Product::find($product_id);
        $current_basket_item = [];
        $current_basket_item_idx = "";


        /**
         * Überprüfung ob das Produkt vorhanden ist
         */
        if(empty($product)){
            $result['errors'][] = "couldn't find Product";
            return $result;
        }
        
        
        /**
         * befindet sich das Produkt bereits im Warenkorb
         */
        foreach($this->items as $idx => $basket_item)
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

            unset($this->items[$current_basket_item_idx]);
            $this->items = array_values($this->items); #Das wird benötigt um den Array index zurücsetzen
            $this->save();
            $result['success'] = true;

        } elseif( ($quantity - $current_basket_item->quantity) < 0) {
            
            $current_basket_item->quantity = $current_basket_item->quantity - $quantity;
            $this->save();
            $result['success'] = true;
            $result['response'] = $current_basket_item;

        } else {
            $result['errors'][] = "quantity is to high!";
        }

        
        return $result;
        
    }

    /**
     * Mit dieser Funktion kann die quantity gesetzt werden
     */
    public function setProduct(int $product_id, int $quantity): array
    {
        $result = ['success' => false, 'errors' => null, 'response' => null];
        $product = Product::find($product_id);
        $current_basket_item = [];
        $current_basket_item_idx = "";


        /**
         * Überprüfung ob das Produkt vorhanden ist
         */
        if(empty($product)){
            $result['errors'][] = "couldn't find Product";
            return $result;
        }
        
        
        /**
         * befindet sich das Produkt bereits im Warenkorb
         */
        foreach($this->items as $idx => $basket_item)
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
        if( $quantity <= 0){

            unset($this->items[$current_basket_item_idx]);
            $this->items = array_values($this->items); #Das wird benötigt um den Array index zurücsetzen
            $this->save();
            $result['success'] = true;

        } elseif( $quantity <= $product->stock ) {
            
            $current_basket_item->quantity = $quantity;
            $this->save();
            $result['success'] = true;
            $result['response'] = $current_basket_item;

        } else {
            $result['errors'][] = "quantity is to high!";
        }

        
        return $result;
        
    }

    public function total():float
    {
        $total = floatval(0);
        foreach($this->items as $idx => $basket_item)
        {
            $total = $total + $basket_item->price;
        }

        return $total;
    }

    /**
     * Gibt wie viele Produkte samt der Menge im Warenkorb liegen
     */
    public static function count ():int 
    {
        $basket = self::get();
        $count = 0;

        foreach($basket->items as $basket_item)
        {
            $count = $count + $basket_item->quantity;
        }

        return $count;
    }
}
