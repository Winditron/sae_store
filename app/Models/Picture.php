<?php

namespace App\Models;

use Core\Database;
use Core\Models\AbstractFile;

class Picture extends AbstractFile
{
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

    public static function findByProduct(int $product_id): array
    {
        $database = new Database();

        $tablename = self::getTablenameFromClassname();

        $result = $database->query("
            SELECT  {$tablename}.*
            FROM    {$tablename}
            JOIN    `products_pictures_map` on `pictures`.`id` = `products_pictures_map`.`picture_id`
            WHERE   `products_pictures_map`.`product_id` = {$product_id}
        ");

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
}