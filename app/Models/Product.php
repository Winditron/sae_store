<?php

namespace App\Models;

use Core\Models\AbstractModel;
use Core\Traits\HasSlug;

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
        return true;
    }

    public function files()
    {
        return Picture::findByProduct($this->id);
    }

    public function formatPrice ():string
    {
        return number_format($this->price , 2, ",", " " );
    }
}

