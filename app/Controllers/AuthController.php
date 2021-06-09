<?php

namespace App\Controllers;

use App\Models\User;
use Core\Helpers\Redirector;
use Core\Session;
use Core\Validator;
use Core\View;

class AuthController
{

    public function loginForm()
    {
        if (User::isLoggedIn()) {
            Redirector::redirect(BASE_URL);
        }

        View::render('authentication/login');
    }

    public function login()
    {
        $errors = [];

        $user = User::findByEmail($_POST['email']);

        if (empty($user) || !$user->checkPassword($_POST['password'])) {
            $errors[] = 'Das Passwort oder die Email ist nicht korrekt!';
        } else {
            $remember = false;

            if (isset($_POST['remember'])) {
                $remember = true;
            }

            if ($user->is_admin) {
                $user->login(BASE_URL . '/admin', $remember);
            } else {
                $user->login(BASE_URL . '/home', $remember);
            }
        }

        Session::set('errors', $errors);
        Redirector::redirect(BASE_URL . '/login');
    }

    public function logout()
    {
        USer::logout(BASE_URL);
    }

    public function signupForm()
    {
        View::render('authentication/signup');
    }

    public function signup()
    {

        $validator = new Validator();

        $validator->letters($_POST['firstname'], 'Vorname', false);
        $validator->letters($_POST['secondname'], 'Nachname', false);
        $validator->email($_POST['email'], 'Email-Adresse', true);
        $validator->password($_POST['password'], 'Passwort', true);
        $validator->tel($_POST['phone'], 'Phone', false);
        $validator->textnum($_POST['address'], 'Adresse', false);
        $validator->letters($_POST['country'], 'Ort', false);
        $validator->int((int) $_POST['zip'], 'PLZ', false);

        $validator->compare([
            $_POST['password'],
            'Password',
        ], [
            $_POST['password-repeat'],
            'Password wiederholen',
        ]);

        $errors = $validator->getErrors();

        if (!empty(User::findByEmail($_POST['email']))) {
            $errors[] = 'Die angegebene Email Adresse wird bereitz von einem Konto benutzt!';
        }

        if (!empty($errors)) {
            Session::set('errors', $errors);
            Redirector::redirect(BASE_URL . '/sign-up');
        }

        $user = new User();
        $user->firstname = trim($_POST['firstname']);
        $user->secondname = trim($_POST['secondname']);
        $user->email = trim($_POST['email']);
        $user->setPassword($_POST['password']);
        $user->phone = trim($_POST['phone']);
        $user->address = trim($_POST['address']);
        $user->country = trim($_POST['country']);
        $user->zip = trim($_POST['zip']);

        if ($user->save()) {
            $success = ['Das Konto wurde erfolgreich angelegt!'];
            Session::set('success', $success);
            Redirector::redirect(BASE_URL . '/login');
        } else {
            $errors[] = 'Beim Anlegen des Kontos ist etwas schiefgelaufen!';
            Session::set('errors', $errors);
            Redirector::redirect(BASE_URL . '/sign-up');
        }
    }

}
