<?php 
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv -> safeLoad();

require_once __DIR__ . '/../includes/app.php';

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos

ActiveRecord::setDB($db);