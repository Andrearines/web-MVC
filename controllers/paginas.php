<?php
namespace controllers;
use MVC\Router;

class paginas{

    public static function index(Router $router){
        $router->view('home/index.php',['inicio'=> true]);
    }
}