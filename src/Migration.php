<?php namespace Src;

use Model\DataBase;

require_once 'vendor/autoload.php';

abstract class Migration {
    abstract public function up(DataBase $db);
    abstract public function down(DataBase $db);
}

$classArray = explode('-', $argv[2]);
$classArray = array_map(function($str) {
    return ucfirst($str);
}, $classArray);

switch ($argv[1]) {
    case 'generate':
        $migrationName = $argv[2];
        $timestamp = date('Y_m_d_His');
        $className = 'Migration' . implode('', $classArray);
        $fileName = Application::$ROOT_DIR . '/migrations/' 
                                                . 'Migration_' . $timestamp . '_' 
                                                . $migrationName . '.php';

        $template = "<?php\n\n";
        $template .= "use Src\Migration;\n";
        $template .= "use Model\DataBase;\n\n";
        $template .= "class {$className} extends Migration {\n";
        $template .= "    public function up(DataBase \$db) {\n";
        $template .= "        // TODO: Implement migration logic here\n";
        $template .= "    }\n\n";
        $template .= "    public function down(DataBase \$db) {\n";
        $template .= "        // TODO: Implement rollback logic here\n";
        $template .= "    }\n";
        $template .= "}";


        $file = fopen($fileName, 'w');
        fwrite($file, $template);
        fclose($file);
        echo "Migration created: {$fileName}\n";
        break;

    case 'migrate':
        break;

    default:
        echo "Usage: php migration.php [generate|migrate] [migration_name]\n";
        break;
}