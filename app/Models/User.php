<?php

namespace App\Models;

use Core\Models\AbstractUser;
use Core\Database;

class User extends AbstractUser
{
public int $id;
public string $firstname;
public string $secondname;
public string $email;
public string $password;
public string $phone;
public string $address;
public string $country;
public string $zip;
public ?string $avatar = null;
public string $crdate;
public string $tstamp;
public mixed $deleted_at;

    public function fill (array $data)
    {
        $this->id = $data['id'];
        $this->firstname = $data['firstname'];
        $this->secondname = $data['secondname'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->phone = $data['phone'];
        $this->address = $data['address'];
        $this->country = $data['country'];
        $this->zip = $data['zip'];
        $this->is_admin = (bool)$data['is_admin'];
        $this->crdate = $data['crdate'];
        $this->tstamp = $data['tstamp'];
        $this->deleted_at = $data['deleted_at'];      
    }

    public function save ():bool
    {
        $database = new Database();

        $tablename = self::getTablenameFromClassname();

        if(empty($this->id)){

            $result = $database->query("INSERT INTO $tablename SET firstname = ?, secondname = ?, email = ?, password = ?, phone = ?, address = ?, country = ?, zip = ?, is_admin = ?",[
                's:firstname' => $this->firstname,
                's:secondname' => $this->secondname,
                's:email' => $this->email,
                's:password' => $this->password,
                's:phone' => $this->phone,
                's:address' => $this->address,
                's:country' => $this->country,
                's:zip' => $this->zip,
                'i:is_admin' => $this->is_admin
            ]);

        }

        $this->handleInsertResult($database);

        return $result;
    }
}

