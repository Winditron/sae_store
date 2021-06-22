<?php

namespace App\Models;

use Core\Models\AbstractModel;
use Core\Traits\HasSlug;
use Core\Database;
use Core\Validator;

class Order extends AbstractModel
{

    public int $id;
    public ?int $user_id = null; 
    public string $firstname; 
    public string $secondname; 
    public string $email; 
    public string $phone; 
    public string $address; 
    public string $city; 
    public string $zip; 
    public ?string $alt_secondname = null; 
    public ?string $alt_firstname = null; 
    public ?string $alt_phone = null; 
    public ?string $alt_address = null; 
    public ?string $alt_city = null; 
    public ?string $alt_zip = null; 
    public string $products; 
    public string $status = 'offen';
    public string $crdate;
    public string $tstamp;
    public mixed $deleted_at;


    public function fill (array $data)
    {

        $this->id = $data['id'];
        $this->user_id = $data['user_id'];
        $this->firstname = $data['firstname'];
        $this->secondname = $data['secondname'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->address = $data['address'];
        $this->city = $data['city'];
        $this->zip = $data['zip'];
        $this->alt_secondname = $data['alt_secondname'];
        $this->alt_firstname = $data['alt_firstname'];
        $this->alt_phone = $data['alt_phone'];
        $this->alt_address = $data['alt_address'];
        $this->alt_city = $data['alt_city'];
        $this->alt_zip = $data['alt_zip'];
        $this->products = $data['products'];
        $this->status = $data['status'];
        $this->crdate = $data['crdate'];
        $this->tstamp = $data['tstamp'];
        $this->deleted_at = $data['deleted_at'];

    }

    public function save ():bool
    {
        $database = new Database();

        $tablename = self::getTablenameFromClassname();

        if(empty($this->id)){

            $result = $database->query("    INSERT INTO $tablename 
                                            SET `user_id` = ?, `firstname` = ?, `secondname` = ?, `email` = ?, `phone` = ?, `address` = ?, `city` = ?, `zip` = ?, `alt_firstname` = ?, `alt_secondname` = ?, `alt_phone` = ?, `alt_address` = ?, `alt_city` = ?, `alt_zip` = ?, `products` = ?, `status` = ?",[

                    'i:user_id' => $this->user_id,
                    's:firstname' => $this->firstname,
                    's:secondname' => $this->secondname,
                    's:email' => $this->email,
                    's:phone' => $this->phone,
                    's:address' => $this->address,
                    's:city' => $this->city,
                    's:zip' => $this->zip,
                    's:alt_firstname' => $this->alt_firstname,
                    's:alt_secondname' => $this->alt_secondname,
                    's:alt_phone' => $this->alt_phone,
                    's:alt_address' => $this->alt_address,
                    's:alt_city' => $this->alt_city,
                    's:alt_zip' => $this->alt_zip,
                    's:products' => $this->products,
                    's:status' => $this->status
            ]);

        } else {

            return $database->query("   UPDATE  $tablename 
                                        SET `user_id` = ?, `firstname` = ?, `secondname` = ?, `email` = ?, `phone` = ?, `address` = ?, `city` = ?, `zip` = ?, `alt_firstname` = ?, `alt_secondname` = ?, `alt_phone` = ?, `alt_address` = ?, `alt_city` = ?, `alt_zip` = ?, `products` = ?, `status` = ?
                                        WHERE id = ?",[

                    'i:user_id' => $this->user_id,
                    's:firstname' => $this->firstname,
                    's:secondname' => $this->secondname,
                    's:email' => $this->email,
                    's:phone' => $this->phone,
                    's:address' => $this->address,
                    's:city' => $this->city,
                    's:zip' => $this->zip,
                    's:alt_firstname' => $this->alt_firstname,
                    's:alt_secondname' => $this->alt_secondname,
                    's:alt_phone' => $this->alt_phone,
                    's:alt_address' => $this->alt_address,
                    's:alt_city' => $this->alt_city,
                    's:alt_zip' => $this->alt_zip,
                    's:products' => $this->products,
                    's:status' => $this->status,
                    'i:id' => $this->id

            ]);
            
        }

        $this->handleInsertResult($database);

        return $result;
    }


    public function validateFormData():array
    {
        $errors = [];
        $validator = new Validator();

        $validator->email($_POST['email'], 'Email-Adresse', true);
        $validator->letters($_POST['firstname'], 'Vorname', true);
        $validator->letters($_POST['secondname'], 'Nachname', true);
        $validator->tel($_POST['phone'], 'Phone', true);
        $validator->textnum($_POST['address'], 'Adresse', true);
        $validator->letters($_POST['city'], 'Ort', true);
        $validator->int((int) $_POST['zip'], 'PLZ', true);
        
        if(isset($_POST['alt_delivery']) && $_POST['alt_delivery'] === 'on'){
            $validator->letters($_POST['alt_firstname'], 'Lieferadresse Vorname', true);
            $validator->letters($_POST['alt_secondname'], 'Lieferadresse Nachname', true);
            $validator->tel($_POST['alt_phone'], 'Lieferadresse Phone', true);
            $validator->textnum($_POST['alt_address'], 'Lieferadresse Adresse', true);
            $validator->letters($_POST['alt_city'], 'Lieferadresse Ort', true);
            $validator->int((int) $_POST['alt_zip'], 'Lieferadresse PLZ', true);
        }

        if(isset($_POST['status']) && !empty($_POST['status'])){
            
        /**
         * Hier wird jeder mögliche Status wert durchgegangen und nachgeschaut, ob dieser mit dem übergebenen Wert übereinstimmt
         */
        $validStatusValues = $this->statusValues();
        
        $valid = false;

        foreach($validStatusValues as $validValues){
            if($validValues === $_POST['status']){
                $valid = true;
                break;
            }
        }

        if (!$valid){
            $errors[] = "Der Status ist kein gültiger Wert.";
        }        

        }

        $errors = $validator->getErrors();

        return $errors;
    }
    
    public function statusValues():array
    {
        return $this->getEnumValues('status');
    }

    public static function findByUser(int $user_id, mixed $order_id = null)
    {
        if(empty($order_id)){
            return self::findWhere("user_id", $user_id);
        }

        $database = new Database;
        $tablename = self::getTablenameFromClassname();

        $result = $database->query("  SELECT $tablename.*
                            FROM $tablename
                            WHERE user_id = ? AND id = ?", [
                                'i:user_id' => $user_id,
                                'i:id' => $order_id
                            ]);

        $result = self::handleUniqueResult($result);

        return $result;

    }

    public function total()
    {
        $total = 0;

        /**
         * Berechnung von total
         */
        foreach (json_decode($this->products) as $item) {
            $total = $total + $item->price * $item->quantity;
        }

        return $total;
    }

    public function amountOfProducts()
    {
        $count = 0;

        /**
         * Berechnung der Anzahl
         */
        foreach (json_decode($this->products) as $item) {
            $count = $count +  $item->quantity;
        }

        return $count;
    }
}

