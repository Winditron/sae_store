<?php

namespace App\Models;

use Core\Database;
use Core\Models\AbstractFile;

class Picture extends AbstractFile
{
    
    const TABLENAME_PRODUCTS_MAP = "products_pictures_map";

    public int $id;
    public string $name;
    public string $path;
    public ?string $alttext;
    public string $crdate;
    public string $tstamp;
    public mixed $deleted_at;


    public function fill($data)
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->path = $data['path'];
        $this->alttext = $data['alttext'];
        $this->crdate = $data['crdate'];
        $this->tstamp = $data['tstamp'];
        $this->deleted_at = $data['deleted_at'];
    }

    public function save():bool
    {
        return true;
    }  

    /**
     * findet alle Bilder oder nur ein angegebenes Bild, bei dem eine Verknüpfung zu einem Product besteht
     */
    public static function findByProduct(int $product_id, ?int $picture_id = null): array
    {
        $database = new Database();

        $tablename = self::getTablenameFromClassname();
        $tablename_map = self::TABLENAME_PRODUCTS_MAP;


        $sql = "    SELECT  {$tablename}.*
                    FROM    {$tablename}
                    JOIN    `{$tablename_map}` on `pictures`.`id` = `{$tablename_map}`.`picture_id`
                    WHERE   `{$tablename_map}`.`product_id` = ?";

        $parameter_values = ['i:product_id' => $product_id];
        
        if(!empty($picture_id)){
            $sql = $sql . " AND `picture_id` = ?";
            $parameter_values['i:picture_id'] = $picture_id;
        }
        
        $result = $database->query($sql, $parameter_values);

        $result= self::handleResult($result);

        return $result;
    }

    

    public function getFilePath(bool $absolute = false, bool $http = false):string 
    {
        $path = $this->path . '/' . $this->name;

        if( $absolute === true){

            if($http === true){
                return BASE_URL . '/storage/' . $path;
            } else {
                return AbstractFile::getStoragePath() . '/' . $path;
            }

        }
    }

    public function getImgTag():string
    {
        return sprintf('<img src="%s" alt="%s">', $this->getFilePath(true, true), $this->alttext);
    }

    public static function allNotBindedToProduct(int $product_id)
    {
        $database = new Database();
        $tablename_map = self::TABLENAME_PRODUCTS_MAP;

        $tablename = self::getTablenameFromClassname();

        /**
         * ICh krige einfach die SQL abfrage nicht hin
         */

        $sql = "    SELECT  `{$tablename}`.*
                    FROM    `{$tablename}`
                    LEFT JOIN    `{$tablename_map}` on `pictures`.`id` = `{$tablename_map}`.`picture_id`
                    GROUP BY `{$tablename_map}`.`product_id`
                    HAVING  `{$tablename_map}`.`product_id` != {$product_id} OR `{$tablename_map}`.`product_id` IS NULL";

                    #var_dump($sql);

        $result = $database->query($sql);

        $result= self::handleResult($result);

        return $result;
    }

}