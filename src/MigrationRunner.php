<?php

namespace Src;

require_once __DIR__ . "/../vendor/autoload.php";

use Src\MigrationRepository;
use Model\DataBase;

class MigrationRunner
{
    public MigrationRepository $migrateRepo;

    public function __construct(MigrationRepository $migrateRepo)
    {
        $this->migrateRepo = $migrateRepo;
    }

    /**
     * Get the last batch implemented migrations
     * and implement not migrated ones on new batch
     *
     * @return void
     */
    public function migrate()
    {
        $migrates = glob(__DIR__ . "/../migrations/*.php");
        sort($migrates);
        $newBatch = $this->getPreBatch() + 1;

        foreach ($migrates as $migrate) {
            $migrateName = pathinfo($migrate, PATHINFO_FILENAME);

            if ($this->migrateRepo->isMigrateAdded($migrateName)) {
                continue;
            }

            $migration = require $migrate;
            $migration->up(new DataBase());

            $this->migrateRepo->addMigration($migrateName, $newBatch);
            echo "Migrated: {$migrateName}\n";
        }
    }

    /**
     * Get the migrations implemented on last batch and roll them back
     *
     * @return void
     */
    public function rollback()
    {
        $lastMigrations = $this->migrateRepo->getLastBatchMigrations();
        rsort($lastMigrations);

        foreach ($lastMigrations as $migrate) {
            $migrate = $migrate['migrate'];
            $migration = require __DIR__ . "/../migrations/$migrate.php";
            $migration->down(new DataBase());

            $this->migrateRepo->deleteMigration($migrate);
            echo "Rolled back: {$migrate}\n";
        }
    }

    /**
     * Helper function to get last batch number
     *
     * @return integer
     */
    private function getPreBatch(): int
    {
        $preBatch = $this->migrateRepo->getLastBatch();
        if (!isset($preBatch)) {
            return 0;
        }
        return $preBatch;
    }
}
