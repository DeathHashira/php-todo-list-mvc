<?php namespace Src;

class Sessions {
    static function userAuthenticated(int $userId) : void 
    {
        $_SESSION["user_id"] = $userId;
        $_SESSION["created_at"] = time();
    }

    static function checkAuthentication() : void 
    {
        if (!isset($_SESSION["user_id"])) {
            header("Location: /login");
            exit;
        } elseif (time() - $_SESSION["created_at"] > 1800) {
            header("Location: /login");
            exit;
        } else {
            return;
        }
    }
}