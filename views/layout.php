<?php

if(!isset($_SESSION)){
session_start();
}
$auth = $_SESSION['admin'] ?? null;
if(!isset($inicio)){

    $inicio=false;

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../build/css/app.css">
    <title></title>
</head>
<body>

    <header class="header <?php echo $inicio ?"inicio":"" ?>">
        <div class="contenedor contenido-header">

            <div class="barra">
                <a href="/">
                    <img src="" alt="logo">
                </a>
                <div class="derecha">
                   
                    <nav class="navegacion">
                      
                        <?php
                        //if($auth):?>
                        <!--<a href="/serrar-secion.php">cerrar secion</a>-->
                        <?php 
                        //else:?>
                           <!-- <a href="/login.php">login</a>-->
                        <?php
                        // endif?>
                    </nav>
                </div>
           </div> <!--barra-->

            <h1> </h1>
        </div>
    </header>

    <?php echo $contenedor?>
   
    
<footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                
            </nav>
        </div>
        <?php 
        
        $fecha =date("y");

        ?>
        <p class="copyright">todos los derechos resevados <?php echo(date("Y"))?> &copy;</p>
    </footer>
         <script src="../build/js/bundle.min.js"></script>   
    </body>
    </html>