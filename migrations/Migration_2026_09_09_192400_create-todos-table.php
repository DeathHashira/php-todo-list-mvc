<?php

use Src\Migration;
use Model\DataBase;

class MigrationCreateTodosTable extends Migration {
    public function up(DataBase $db) {
        $conn = $db->getConnection();
        $conn->exec("CREATE TABLE todos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            status BOOLEAN DEFAULT FALSE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            user_id INT,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )");
    }

    public function down(DataBase $db) {
        $conn = $db->getConnection();
        $conn->exec("DROP TABLE IF EXISTS todos");
    }
}