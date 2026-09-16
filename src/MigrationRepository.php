<?php namespace Src;

require_once __DIR__ . "/../vendor/autoload.php";
use Model\DataBase;
use PDO;

class MigrationRepository {
    public $conn;

    public function __construct()
    {
        $this->conn = (new DataBase())->getConnection();
    }

    public function initMigrations() : bool 
    {
        return $this->conn->exec("CREATE TABLE migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migrate VARCHAR(255) NOT NULL,
            batch INT UNSIGNED NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
    }

    public function addMigration(string $migration, int $batch) : bool
    {
        $statement = $this->conn->prepare("INSERT INTO migrations (migrate, batch) 
                                                                VALUES (?, ?)");
        return $statement->execute([$migration, $batch]);
    }

    public function getLastBatch() : ?int
    {
        $statement = $this->conn->prepare("SELECT MAX(batch) AS batch FROM migrations");
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC)['batch'];
    }

    public function getLastBatchMigrations() : array
    {
        $statement = $this->conn->prepare("SELECT migrate FROM migrations WHERE batch = (
                                                                                SELECT MAX(batch)
                                                                                FROM migrations)");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteMigration(string $migration) : void
    {
        $statement = $this->conn->prepare("DELETE FROM migrations WHERE migrate = ?");
        $statement->execute([$migration]);
    }

    public function isMigrateAdded(string $migrate) : bool
    {
        $statement = $this->conn->prepare("SELECT COUNT(*) FROM migrations WHERE migrate = ?");
        $statement->execute([$migrate]);
        return $statement->fetchColumn() > 0;
    }
}