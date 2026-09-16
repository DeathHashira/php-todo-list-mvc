<?php

require_once __DIR__ . "/../vendor/autoload.php";
use Src\MigrationRepository;
use Src\MigrationRunner;

if ($argv[1] === "generate") {
    $classArray = explode('-', $argv[2]);
    $classArray = array_map(function($str) {
                            return ucfirst($str);
                }, $classArray);
}

switch ($argv[1]) {
    case 'init':
        $initMigrations = (new MigrationRepository())->initMigrations();
        if (!$initMigrations) {
            echo "Initilization successful.";
        } else {
            echo "Initialization failed.";
        }
        break;

    case 'generate':
        $migrationName = $argv[2];
        $timestamp = date('YmdHis');
        $className = 'Migration' . $timestamp . implode('', $classArray);
        $fileName = __DIR__ . '/../migrations/' 
                            . $className . '.php';

        $template = "<?php\n\n";
        $template .= "require_once __DIR__ . '/../vendor/autoload.php';\n\n";
        $template .= "use Src\Migration;\n";
        $template .= "use Model\DataBase;\n\n";
        $template .= "return new class extends Migration {\n";
        $template .= "    public function up(DataBase \$db) : void \n";
        $template .= "    {\n";
        $template .= "        // TODO: Implement migration logic here\n";
        $template .= "    }\n\n";
        $template .= "    public function down(DataBase \$db) : void \n";
        $template .= "    {\n";
        $template .= "        // TODO: Implement rollback logic here\n";
        $template .= "    }\n";
        $template .= "};";


        $file = fopen($fileName, 'w');
        fwrite($file, $template);
        fclose($file);
        echo "Migration created: {$fileName}\n";
        break;

    case 'migrate':
        (new MigrationRunner(new MigrationRepository))->migrate();
        break;

    case 'rollback':
        (new MigrationRunner(new MigrationRepository))->rollback();
        break;

    default:
        echo "Usage: php migration.php [generate|migrate] [migration_name]\n";
        break;
}