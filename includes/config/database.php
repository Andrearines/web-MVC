<?php

function conectaDB(): mysqli{
    $db = new mysqli("localhost","root","","");

    if(!$db){
        echo"conecion fallida";
        exit;
    }

    return $db;
}
