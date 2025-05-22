<?php
require_once __DIR__. '/../includes/app.php';
use controllers\paginas;
use controllers\API;
use MVC\Router;
$r=new Router;
$r->get("/",[paginas::class,'index']);
$r->post("/",[paginas::class,'index']);


$r->Rutas();