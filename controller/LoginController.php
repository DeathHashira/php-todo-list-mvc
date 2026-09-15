<?php namespace Controller;

use Model\Users;
use Src\Sessions;

class LoginController
{
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