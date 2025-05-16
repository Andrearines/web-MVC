<?php
if(!isset($_SESSION)){
session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/build/css/app.css">
    <title></title>
</head>
<body>
    <header class="header <?php echo $inicio ?"inicio":"" ?>">
        <div class="contenedor contenido-header">

            <div class="barra">
                <a href="/index.php">
                    <img src="" alt="logo">
                </a>
                <div class="derecha">
                    <nav class="navegacion">
                       
                    </nav>
                </div>
           </div> <!--barra-->
            <h1> </h1>
        </div>
    </header>