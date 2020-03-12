<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;
use app\core\Database;
use app\models\Category;
use app\models\Project;

$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__).'/.env');

$db = Database::getInstance();

Category::refreshData($db);
Project::refreshData($db);

echo 'DB is updated!';
