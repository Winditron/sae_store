<?php

namespace App\Models;

use Core\Models\AbstractModel;
use Core\Traits\HasSlug;
use Core\Database;

class Category extends AbstractModel
{
    use HasSlug;

    const TABLENAME = 'categories';

    public int $id;
    public string $title;
    public string $slug;
    public string $description;
    public string $crdate;
    public string $tstamp;
    public mixed $deleted_at;

    public function fill (array $data)
    {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->slug = $data['slug'];
        $this->description = $data['description'];
        $this->crdate = $data['crdate'];
        $this->tstamp = $data['tstamp'];
        $this->deleted_at = $data['deleted_at'];      
    }

    public function save ():bool
    {
        $database = new Database();

        $tablename = self::getTablenameFromClassname();

        if(empty($this->id)){

            $result = $database->query("INSERT INTO $tablename SET title = ?, slug = ?, description = ?",[
                's:titile' => $this->name,
                's:slug' => $this->slug,
                's:description' => $this->description
            ]);

        } else {
            return $database->query("UPDATE  $tablename SET title = ?, slug = ?, description = ? WHERE id = {$this->id}",[
                's:name' => $this->title,
                's:slug' => $this->slug,
                's:description' => $this->description,

            ]);
        }

        $this->handleInsertResult($database);

        return $result;
    }

    public static function findByProduct(int $product_id):array
    {
        $database = new Database();

        $tablename = self::getTablenameFromClassname();

        $result = $database->query("  SELECT {$tablename}*
                                        FROM {$tablename}
                                        JOIN products ON products.category = categories.id
                                        WHERE products.id = ? ", [
                                            'i:products.id' => $product_id
        ]);

        $result = self::handleResult($result);

        return $result;
    }
    
}

