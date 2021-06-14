<?php

namespace Core\Middlewares;

use App\Models\User;
use Core\ApiResponse;
use Core\View;

/**
 * Class AuthMiddleware
 *
 * @package Core\Middlewares
 */
class AuthMiddleware
{

    /**
     * Prüfen, ob der/die eingeloggte User*in ein Admin ist.
     *
     * @return bool|null
     */
    public static function isAdmin (): ?bool
    {
        /**
         * Hier verwenden wir den Nullsafe Operator (?). Dadurch wird kein Fehler auftreten, wenn kein*e User*in
         * eingeloggt und getLoggedIn() somit keine*n User*in zurückgibt und somit dieser leere Rückgabewert auch keine
         * Property is_admin hat. Der Nullsafe Operator wird einfach den Wert des gesamten Ausdrucks auf null setzen.
         */
        return User::getLoggedIn()?->is_admin;
    }

    /**
     * Prüfen, ob der/die eingeloggte User*in ein Admin ist und andernfalls Fehler 403 Forbidden zurückgeben.
     */
    public static function isAdminOrFail ()
    {
        /**
         * Prüfen, ob der/die aktuell eingeloggt User*in Admin ist.
         */
        $isAdmin = self::isAdmin();

        /**
         * Wenn nein, geben wir einen Fehler 403 Forbidden zurück und brechen somit die weitere Ausführung ab.
         */
        if ($isAdmin !== true) {
            View::error403();
        }
    }

    public static function APIloggedInAdminOrFail (){
        /**
         * Um eine der Funktionen nutzen zukönnen muss der angemeltete User ein Admin sein
         */
        $user = User::getLoggedIn();

        /**
         * User muss eingelogt sein
         */
        if(!empty($user))
        {
            /**
             * eigelogter User muss ein Admin sein
             */
            if(!$user->is_admin)
            {
                $error = new \stdClass();
                $error->message = 'You are not allowed to do that';
                $error->code = 403;

                ApiResponse::json($error, 403);
            }
            
        } else {
            $error = new \stdClass();
            $error->message = 'You need to be logged in';
            $error->code = 401;

            ApiResponse::json($error, 401);
        }
    }

}
