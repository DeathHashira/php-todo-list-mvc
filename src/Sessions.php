<?php namespace Src;

/**
 * Session manager for staying logged in
 */
class Sessions {
    /**
     * Create session after successful log in
     *
     * @param integer $userId
     * @return void
     */
    static function userAuthenticated(int $userId) : void 
    {
        $_SESSION["user_id"] = $userId;
        $_SESSION["created_at"] = time();
    }

    /**
     * Keep user logged in if the session exists
     * and it has not been more than 30 minute of last log in
     *
     * @return void
     */
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