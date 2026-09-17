<?php

namespace Src;

use Model\DataBase;

require_once 'vendor/autoload.php';

/**
 * Abstract class to form each migrations
 * Each migration will be created and saved on migrations/ directory
 */
abstract class Migration
{
    abstract public function up(DataBase $db): void;
    abstract public function down(DataBase $db): void;
}
