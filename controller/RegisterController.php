<?php namespace Controller;

require_once __DIR__ . '/../vendor/autoload.php';
use Model\Users;

class RegisterController
{
    public function register(array $data) : bool
    {
        if (array_key_exists("password", $data)) {
            $data["password"] = password_hash($data["password"], PASSWORD_DEFAULT);
        }

        $status = (new Users())->create($data);
        if ($status) {
            header('Location: /todos');
            return true;
        } else {
            header('Location: /register');
            return false;
        }
    }
}