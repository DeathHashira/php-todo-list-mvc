<?php namespace Controller;

use Model\Users;
use Src\Sessions;

class LoginController
{
    /**
     * Check if user email and password is okay
     * If okay, user redirects to main page, if no stays on login page
     *
     * @param string $email
     * @param string $password
     * @return void
     */
    public function checkLogin(string $email, string $password) : void
    {
        $userInfo = (new Users())->read(['password', 'id'], ['email' => $email]);
        
        if (empty($userInfo)) {
            header('Location: /login');
            return;
        }

        $isValid = password_verify($password, $userInfo[0]['password']);

        if ($isValid) {
            Sessions::userAuthenticated($userInfo[0]['id']);
            header('Location: /todos');
            return;
        } else {
            header('Location: /login');
            return;
        }
    }
}