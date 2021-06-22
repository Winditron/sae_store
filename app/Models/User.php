<?php

namespace App\Models;

use Core\Models\AbstractUser;
use Core\Database;
use Core\Traits\SoftDelete;
use Core\Validator;

class User extends AbstractUser
{

    use SoftDelete;

public int $id;
public string $firstname;
public string $secondname;
public string $email;
public string $password;
public string $phone;
public string $address;
public string $city;
public string $zip;
public bool $is_admin = false;
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
        $this->city = $data['city'];
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

            $result = $database->query("INSERT INTO $tablename SET firstname = ?, secondname = ?, email = ?, password = ?, phone = ?, address = ?, city = ?, zip = ?, is_admin = ?",[
                's:firstname' => $this->firstname,
                's:secondname' => $this->secondname,
                's:email' => $this->email,
                's:password' => $this->password,
                's:phone' => $this->phone,
                's:address' => $this->address,
                's:city' => $this->city,
                's:zip' => $this->zip,
                'i:is_admin' => $this->is_admin
            ]);

        }else {
            return $database->query("UPDATE  $tablename SET firstname = ?, secondname = ?, email = ?, password = ?, phone = ?, address = ?, city = ?, zip = ?, is_admin = ? WHERE id = ? ",[
                's:firstname' => $this->firstname,
                's:secondname' => $this->secondname,
                's:email' => $this->email,
                's:password' => $this->password,
                's:phone' => $this->phone,
                's:address' => $this->address,
                's:city' => $this->city,
                's:zip' => $this->zip,
                'i:is_admin' => $this->is_admin,
                'i:id' => $this->id
            ]);
        }

        $this->handleInsertResult($database);

        return $result;
    }

    /**
     * Wenn die übermittelten POST Daten invaliede sind, dann wird ein Array mit Fehlermeldungen returnt
     * Es gibt unterschiedliche Profile zb signup  dort ist password und email required
     */
    public function validateFormData( string $profile):array
    {
        $errors = [];
        $validator = new Validator();

        /**
         * zb beim AdminController mussen nicht die Email und das Passwort angegeben werden
         */
        if($profile === 'admin'){

            if (!empty($_POST['email'])) {
                $validator->email($_POST['email'], 'Email-Adresse');
            }

            if (!empty($_POST['password'])) {
                $validator->password($_POST['password'], 'Passwort');
            }

            if (!empty($_POST['is_admin'])) {
                $validator->checkbox($_POST['is_admin'], 'Administrator');
            }

        } elseif ($profile === 'profile') {

            if (!empty($_POST['email'])) {
                $validator->email($_POST['email'], 'Email-Adresse');
            }

            if (!empty($_POST['password'])) {
                $validator->password($_POST['password'], 'Passwort');
            }
            
        } elseif ($profile === 'signup') {
            
            $validator->email($_POST['email'], 'Email-Adresse', true);
            $validator->password($_POST['password'], 'Passwort', true);
            
        }
        
        $validator->email($_POST['email'], 'Email-Adresse', true);
        $validator->password($_POST['password'], 'Passwort', true);
        $validator->letters($_POST['firstname'], 'Vorname', false);
        $validator->letters($_POST['secondname'], 'Nachname', false);
        $validator->tel($_POST['phone'], 'Phone', false);
        $validator->textnum($_POST['address'], 'Adresse', false);
        $validator->letters($_POST['city'], 'Ort', false);
        $validator->int((int) $_POST['zip'], 'PLZ', false);
        
        

        $validator->compare([
            $_POST['password'],
            'Password',
        ], [
            $_POST['password-repeat'],
            'Password wiederholen',
        ]);


        $errors = $validator->getErrors();

        return $errors;
    }
}

