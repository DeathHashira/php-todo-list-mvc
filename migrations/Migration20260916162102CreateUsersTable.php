<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Src\Migration;
use Model\DataBase;

return new class extends Migration {
    public function up(DataBase $db): void
    {
        $conn = $db->getConnection();

        $conn->exec("CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function down(DataBase $db): void
    {
        $conn = $db->getConnection();
        $conn->exec("DROP TABLE IF EXISTS users");
    }
};
