<?php
require_once __DIR__. '/../includes/app.php';
use controllers\paginas;
use MVC\Router;
$r=new Router;
$r->get("/",[paginas::class,'index']);
$r->Rutas();