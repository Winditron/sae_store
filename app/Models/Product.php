<?php

namespace App\Models;

use Core\Models\AbstractModel;
use Core\Traits\HasSlug;
use Core\Database;
use Core\Traits\SoftDelete;
use Core\Validator;
use Core\Session;
use Core\Traits\HasPrice;

class Product extends AbstractModel
{
    use HasSlug, SoftDelete;

    const TABLENAME_PICTURES_MAP = "products_pictures_map";

    public int $id;
    public string $name;
    public string $slug;
    public ?int $highlight_picture = null;
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
        $this->highlight_picture = $data['highlight_picture'];
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
            
            #var_dump("INSERT INTO $tablename SET name = $this->name, slug = $this->slug, highlight_picture = $this->highlight_picture, description = $this->description, price = $this->price, category = $this->category, watering = $this->watering, sun_location = $this->sun_location, size = $this->size, stock = $this->stock");

            $result = $database->query("INSERT INTO $tablename SET name = ?, slug = ?, highlight_picture = ?, description = ?, price = ?, category = ?, watering = ?, sun_location = ?, size = ?, stock = ?",[
                's:name' => $this->name,
                's:slug' => $this->slug,
                'i:highlight_picture' => $this->highlight_picture,
                's:description' => $this->description,
                'i:price' => $this->price,
                'i:category' => $this->category,
                's:watering' => $this->watering,
                's:sun_location' => $this->sun_location,
                'i:size' => $this->size,
                'i:stock' => $this->stock,
            ]);

        } else {
            return $database->query("UPDATE  $tablename SET name = ?, slug = ?, highlight_picture = ?,  description = ?, price = ?, category = ?, watering = ?, sun_location = ?, size = ?, stock = ? WHERE id = ?",[
                's:name' => $this->name,
                's:slug' => $this->slug,
                'i:highlight_picture' => $this->highlight_picture,
                's:description' => $this->description,
                'i:price' => $this->price,
                'i:category' => $this->category,
                's:watering' => $this->watering,
                's:sun_location' => $this->sun_location,
                'i:size' => $this->size,
                'i:stock' => $this->stock,
                'i:id' => $this->id
            ]);
        }

        $this->handleInsertResult($database);

        return $result;
    }

    public function pictures()
    {
        return Picture::findByProduct($this->id);
    }

    public function findBindedPicture(int $picture_id)
    {
        return Picture::findByProduct($this->id, $picture_id);
    }

    public static function wateringValues():array
    {
        return self::getEnumValues('watering');
    }

    public static function sunlocationValues():array
    {
        return self::getEnumValues('sun_location');
    }

    public function category()
    {
        return Category::findByProduct($this->id);
    }

    /**
     * Wenn die ??bermittelten Daten invaliede sind, dann wird ein Array mit Fehlermeldungen returnt
     */
    public function validateFormData():array
    {
        $errors = [];
        $validator = new Validator();

        $validator->text($_POST['name'],'Produktname' , true);
        $validator->slug($_POST['slug'], 'Slug', true);
        $validator->float((float)$_POST['price'],'Preis', true);
        $validator->int((int)$_POST['category'],'Kategorie', true);
        $validator->int((int)$_POST['size'],'Die maximale Gr????e', true);
        $validator->int((int)$_POST['stock'],'Lagerbestand');
    /**
     * TODO beschreibung validieren
     */
        #$validator->textnum($_POST['description'],'Beschreibung');

        /**
         * deleted imges array validieren
         * es d??rfen nur zahlen sein
         */
        if (isset($_POST['delete-imgs']) && is_array($_POST['delete-imgs']) && !empty($_POST['delete-imgs'])){

            $valid = true;
            
            foreach($_POST['delete-imgs'] as $picture_id => $on){
                if(!is_int($picture_id)){
                    $valid = false;
                }
            }

            if (!$valid){
                $errors[] = "Es konnte keine Bildverkn??pfung gel??scht werden"; 
            }
        }




        /**
         * Higlight bild validieren
         */

        if(isset($_POST['highlight-img']) && is_int($_POST['highlight-img'])){ 

            if(!array_search( (int)$_POST['highlight-img'],  $_POST['delete-imgs'], true)){

                $highlighted_img = $this->findBindedPicture( (int) $_POST['highlight-img']);
    
                if(empty($highlighted_img)){
                    $errors[] = "Das Highlight-Bild muss ein verkn??pftes bild sein.";
                }

            } else {
                $errors[] = "Das Highlight-Bild darf keines von den gl??schten sein.";
            }

        } else {
            $errors[] = "Das Highlight-Bild muss ganzzahlig sein.";
        }

        /**
         * Hier wird jeder m??gliche Watering wert durchgegangen und nachgeschaut, ob dieser mit dem ??bergebenen Wert ??bereinstimmt
         */
        $validWateringValues = self::wateringValues();
        
        $valid = false;

        foreach($validWateringValues as $validValues){
            if($validValues === $_POST['watering']){
                $valid = true;
                break;
            }
        }

        if (!$valid){
            $errors[] = "Der Wasserbedarf ist kein g??ltiger Wert.";
        }

        /**
         * Hier wird jeder m??gliche Watering wert durchgegangen und nachgeschaut, ob dieser mit dem ??bergebenen Wert ??bereinstimmt
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
            $errors[] = "Der Standort ist kein g??ltiger Wert.";
        }        

        $errors = $validator->getErrors();

        return $errors;
    }

    /**
     * l??scht eine oder mehere Verbindungen von einem Product zu einem Bild
     */
    public function unbindPictures(array $picture_ids):bool
    {

        $database = new Database();
        $tablename = self::TABLENAME_PICTURES_MAP;

        /**
         * Hier wird die SQL-Abfrage zusammen gesetzt
         */
        $sql = "DELETE FROM $tablename WHERE `product_id` = ? AND `picture_id` IN ";
        $sql_values = [];#zb (?,?,?) sind die Platzhlalter um sp??ter smt die Werte zu binden
        $values = [];# sind die Werte im Array, die die Query ben??tigt

        $values['i:product_id'] = $this->id;

        foreach($picture_ids as $id){
            
            $sql_values[] = '?';
            $values['i:picture_id-' . count($values ) - 1] =  $id;
            
        }

        $result = false;
        
        /**
         * Es muss mindestens die Product id und ein Picture angegeben sein, um die SQL Abfrage auszuf??hren
         */
        if(!empty($values['i:product_id']) && !empty($values['i:picture_id-0'])){
            
            $sql = $sql . '(' . join(", ", $sql_values) . ')'; #Hier wird die Abfrage fertig gestellt
            
            $result = $database->query($sql, $values);

            /**
             * Falls eines der gel??schten Bilder das Highlight Bild ist setze das highlight im Product auf ein anderes verkn??pftes Bild oder auf null
             */
            if(array_search($this->highlight_picture, $values, true)){

                $this->highlight_picture = null;

                /**
                 * Falls es ein verf??gbares verkn??pftes Bild gibt setze es als Highlight Bild
                 */
                $binded_picture = $this->pictures();

                if(!empty($binded_picture)){
                    $this->highlight_picture = $binded_picture[0]->id;
                }

                $this->save();
            }

        }

        return $result;    
    }



    /**
     * Product mit einem/mehrere Bild/ern verkn??pfen
     * Gibt ein Array zur??ck aus indem steht ob die (bool) SQL Abfrage durchgef??hrt werden konnte und ob Errors vohanden sind
     */
    public function bindPictures(array $picture_ids):array
    {
        
        $database = new Database();
        $tablename = self::TABLENAME_PICTURES_MAP;

        /**
         * Es werden alle id der verkn??pften Bilder ben??tigt, um sp??ter DoppeleEintr??ge zu verhindern
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


            if($dopple_id !== false){
                $errors[] = $bindedPictures[$dopple_id]->name . ' konnte nicht verkn??pft werden!';
                continue;
            }
            
            $sql_values[] = '( ?, ?)';
        
            $values['i:product_id-' . count($values )] =  $this->id;
            $values['i:picture_id-' . count($values ) - 1] =  $id;
            
        }
        
        /**
         * Falls Picture ids im Array sind, dann soll die SQL Abfrage ausgef??hrt werden, sonst nicht
         */
        $result = false;

        if(!empty($values)){
            
            $sql = $sql . join(", ", $sql_values);
            $result = $database->query($sql, $values);
            
            /**
             * Falls noch kein Bild ein Highlight Bild ist setze eins nach dem hinzuf??gen
             */
            if(empty($this->highlight_picture)){

                $this->highlight_picture = $values['i:picture_id-0'];
                
                $this->save();
                
            }

        };
        

        return[ $result ,  $errors];
    }

    /**
     * Mit Hilfe dieser Funktion wird das Anzeige Bild des Produkts ausgegeben, als obeject oder als HtmlTag.
     * Falls das Highlight Bild nicht gesetzt oder gefunden wurde nimmt die Funktion ein verkn??pftes Bild.
     */
    public function highlightPicture(bool $htmlTag = false):array|string
    {
        $picture = $this->highlight_picture;

        if(!empty($picture)){
            $picture = $this->findBindedPicture($picture);
        }

        $result = [];  
        
        if($htmlTag){
            $result = '';
        }

        if(!empty($picture)){
            
            $result = $picture;
            
            if($htmlTag){
                $result = $picture[0]->getImgTag();
            }

        } else {

            $picture = $this->pictures();

            if(!empty($picture)){

                $picture = $picture[0];

                $result = $picture;
                
                if($htmlTag){
                    $result = $picture->getImgTag();
                }

            }


        }

        return $result;
    }
}
