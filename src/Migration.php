<?php namespace Src;

use Model\DataBase;

require_once 'vendor/autoload.php';

abstract class Migration {
    abstract public function up(DataBase $db): void;
    abstract public function down(DataBase $db): void;
}