<?php

namespace App\Models;

use Core\Models\AbstractModel;
use Core\Traits\HasSlug;
use Core\Database;


class Product extends AbstractModel
{
    use HasSlug;

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
}
