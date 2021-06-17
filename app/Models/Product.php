<?php

namespace App\Models;

use Core\Models\AbstractModel;
use Core\Traits\HasSlug;
use Core\Database;
use Core\Traits\SoftDelete;
use Core\Validator;
use Core\Session;

class Product extends AbstractModel
{
    use HasSlug, SoftDelete;

    const TABLENAME_PICTURES_MAP = "products_pictures_map";

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

    public function pictures()
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

        $tablename = self::TABLENAME_PICTURES_MAP;

        $results = $database->query("DELETE FROM {$tablename} WHERE product_id = ? AND picture_id = ?", [
            'i:product_id' => $this->id,
            'i:picture_id' => $picture_id
        ]);

        return $results;
    }

    /**
     * Product mit einem/mehrere Bild/ern verknüpfen
     * Gibt ein Array zurück aus indem steht ob die (bool) SQL Abfrage durchgeführt werden konnte und ob Errors vohanden sind
     */
    public function bindPictures(array $picture_ids):array
    {
        
        $database = new Database();
        $tablename = self::TABLENAME_PICTURES_MAP;

        /**
         * Es werden alle id der verknüpften Bilder benötigt, um später DoppeleEinträge zu verhindern
         */
        $bindedPictures = $this->pictures();
        
        $binded_ids = [];

        foreach ($bindedPictures as $picture){
            $binded_ids[] =  $picture->id;
        }


        
        /**
         * Hier wird die SQL-Abfrage zusammen gesetzt
         */
        $sql = "INSERT INTO {$tablename} (product_id, picture_id) VALUES ";
        $sql_values = [];
        $values = [];

        $errors = [];

        foreach($picture_ids as $id){
            $dopple_id = array_search($id, $binded_ids, true); 
            var_dump($id, $dopple_id, $bindedPictures[$dopple_id]);

            if($dopple_id !== false){
                $errors[] = $bindedPictures[$dopple_id]->name . ' konnte nicht verknüpft werden!';
                continue;
            }

            $picture = Picture::findOrFail($id);

            
            $sql_values[] = '( ?, ?)';
        
            $values['i:' . count($values )] =  $this->id;
            $values['i:' . count($values )] =  $id;
            
        }
        
        /**
         * Falls Bilder hinzugefügt werden sollen, dann soll die SQL Abfrage ausgeführt werden, sonst nicht
         */
        $result = false;
        
        if(!empty($values)){
            
            $sql = $sql . join(", ", $sql_values);
            $result = $database->query($sql, $values);
            
        };
        

        return[ $result ,  $errors];
    }
}
