<?php

require_once __DIR__ . "/../config/Environment.php";

function conectaDB(): mysqli{
    // Cargar variables de entorno
    Environment::load();
    
    $host = Environment::get('DB_HOST', 'localhost');
    $user = Environment::get('DB_USER', 'root');
    $password = Environment::get('DB_PASSWORD', '');
    $database = Environment::get('DB_NAME', '');
try{
    $db = new mysqli($host, $user, $password, $database);

    if($db->connect_error){
        if (Environment::getBool('APP_DEBUG', true)) {
            echo "Error de conexión: " . $db->connect_error;
        } else {
            echo "Error de conexión a la base de datos";
        }
        exit;
    }

    return $db;
} catch (Exception $e) {
    if (Environment::getBool('APP_DEBUG', true)) {
        echo "Error de conexión: " . $e->getMessage();
    } else {
        echo "Error de conexión a la base de datos";
    }
    exit;
}
}
