<?php

namespace App\Models;

use Core\Models\AbstractModel;
use Core\Traits\HasSlug;
use Core\Database;
use Core\Validator;

class Product extends AbstractModel
{
    use HasSlug;

    const Tablename_Pictures_map = "products_pictures_map";

    public int $id;
    public string $name;
    public string $slug;
    public string $description;
    public float $price;
    public int $category;
    public string $watering;
    public string $sun_location;
    public int $size;  
    public int $stock;
    public string $crdate;
    public string $tstamp;
    public mixed $deleted_at;

    public function fill (array $data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->slug = $data['slug'];
        $this->description = $data['description'];
        $this->price = $data['price'];
        $this->category = $data['category'];
        $this->watering = $data['watering'];
        $this->sun_location = $data['sun_location'];
        $this->size = $data['size'];
        $this->stock = $data['stock'];
        $this->crdate = $data['crdate'];
        $this->tstamp = $data['tstamp'];
        $this->deleted_at = $data['deleted_at'];      
    }

    public function save ():bool
    {
        $database = new Database();

        $tablename = self::getTablenameFromClassname();

        if(empty($this->id)){

            $result = $database->query("INSERT INTO $tablename SET name = ?, slug = ?, description = ?, price = ?, category = ?, watering = ?, sun_location = ?, size = ?, stock = ?",[
                's:name' => $this->name,
                's:slug' => $this->slug,
                's:description' => $this->description,
                'i:price' => $this->price,
                'i:category' => $this->category,
                's:watering' => $this->watering,
                's:sun_location' => $this->sun_location,
                'i:size' => $this->size,
                'i:stock' => $this->stock,
            ]);

        } else {
            return $database->query("UPDATE  $tablename SET name = ?, slug = ?, description = ?, price = ?, category = ?, watering = ?, sun_location = ?, size = ?, stock = ? WHERE id = {$this->id}",[
                's:name' => $this->name,
                's:slug' => $this->slug,
                's:description' => $this->description,
                'i:price' => $this->price,
                'i:category' => $this->category,
                's:watering' => $this->watering,
                's:sun_location' => $this->sun_location,
                'i:size' => $this->size,
                'i:stock' => $this->stock,
            ]);
        }

        $this->handleInsertResult($database);

        return $result;
    }

    public function files()
    {
        return Picture::findByProduct($this->id);
    }

    public function formatPrice ():string
    {
        return number_format($this->price , 2, ",", " " );
    }

    public function wateringValues():array
    {
        return self::getEnumValues('watering');
    }

    public function sunlocationValues():array
    {
        return self::getEnumValues('sun_location');
    }

    public function category()
    {
        return Category::findByProduct($this->id);
    }

    /**
     * Wenn die übermittelten Daten invaliede sind, dann wird ein Array mit Fehlermeldungen returnt
     */
    public function validateFormData():array
    {
        $errors = [];
        $validator = new Validator();

        $validator->text($_POST['name'],'Produktname' , true);
        $validator->slug($_POST['slug'], 'Slug', true);
        $validator->float((float)$_POST['price'],'Preis', true);
        $validator->int((int)$_POST['category'],'Kategorie', true);
        $validator->int((int)$_POST['size'],'Die maximale Größe', true);
        $validator->int((int)$_POST['stock'],'Lagerbestand');

    /**
     * TODO beschreibung validieren
     */
        #$validator->textnum($_POST['description'],'Beschreibung');

        /**
         * Hier wird jeder mögliche Watering wert durchgegangen und nachgeschaut, ob dieser mit dem übergebenen Wert übereinstimmt
         */
        $validWateringValues = $this->wateringValues();
        
        $valid = false;

        foreach($validWateringValues as $validValues){
            if($validValues === $_POST['watering']){
                $valid = true;
                break;
            }
        }

        if (!$valid){
            $errors[] = "Der Wasserbedarf ist kein gültiger Wert.";
        }

                /**
         * Hier wird jeder mögliche Watering wert durchgegangen und nachgeschaut, ob dieser mit dem übergebenen Wert übereinstimmt
         */
        $validSunLocation = $this->sunlocationValues();
        
        $valid = false;

        foreach($validSunLocation as $validValues){
            if($validValues === $_POST['sun_location']){
                $valid = true;
                break;
            }
        }

        if (!$valid){
            $errors[] = "Der Standort ist kein gültiger Wert.";
        }
        

        $errors = $validator->getErrors();

        return $errors;
    }

    /**
     * löscht eine Verbindung von dem Product zu einem Bild
     */
    public function unbindPicture(int $picture_id):bool
    {
        $database = new Database();

        $tablename = self::Tablename_Pictures_map;

        $results = $database->query("DELETE FROM {$tablename} WHERE product_id = ? AND picture_id = ?", [
            'i:product_id' => $this->id,
            'i:picture_id' => $picture_id
        ]);

        return $results;
    }
}
