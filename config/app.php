<?php 
require "funciones.php";
require "Environment.php";
require __DIR__."/../db/database.php";
require __DIR__."/../vendor/autoload.php";

// Cargar variables de entorno al inicio
Environment::load();
use models\main;
main::setDb(conectaDB());
