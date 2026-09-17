<?php namespace Src;

require_once __DIR__ . "/../vendor/autoload.php";
use Model\DataBase;
use PDO;

/**
 * CRUD implementation specifically for migrations table 
 */
class MigrationRepository {
    public $conn;

    public function __construct()
    {
        $this->conn = (new DataBase())->getConnection();
    }

    /**
     * Create migrations table
     *
     * @return boolean
     */
    public function initMigrations() : bool 
    {
        return !$this->conn->exec("CREATE TABLE migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migrate VARCHAR(255) NOT NULL,
            batch INT UNSIGNED NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )");
    }

    /**
     * Add each migrations to table after migrate
     *
     * @param string $migration
     * @param integer $batch
     * @return boolean
     */
    public function addMigration(string $migration, int $batch) : bool
    {
        $statement = $this->conn->prepare("INSERT INTO migrations (migrate, batch) 
                                                                VALUES (?, ?)");
        return !$statement->execute([$migration, $batch]);
    }

    /**
     * Get batch number for last migrated migrations
     *
     * @return integer|null
     */
    public function getLastBatch() : ?int
    {
        $statement = $this->conn->prepare("SELECT MAX(batch) AS batch FROM migrations");
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC)['batch'];
    }

    /**
     * Get migrated migrations name for last batch
     *
     * @return array
     */
    public function getLastBatchMigrations() : array
    {
        $statement = $this->conn->prepare("SELECT migrate FROM migrations WHERE batch = (
                                                                                SELECT MAX(batch)
                                                                                FROM migrations)");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Delete specific migration
     *
     * @param string $migration
     * @return void
     */
    public function deleteMigration(string $migration) : void
    {
        $statement = $this->conn->prepare("DELETE FROM migrations WHERE migrate = ?");
        $statement->execute([$migration]);
    }

    /**
     * Check if the migration is in the list (migrated)
     *
     * @param string $migrate
     * @return boolean
     */
    public function isMigrateAdded(string $migrate) : bool
    {
        $statement = $this->conn->prepare("SELECT COUNT(*) FROM migrations WHERE migrate = ?");
        $statement->execute([$migrate]);
        return $statement->fetchColumn() > 0;
    }
}