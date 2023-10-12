<?php

//asa o sa avem acces la variabila globala sesison
//dar cum avem dejadeschisa o sesiune in admin/index.php (si ca sa nu ne dea vro erroare ca deja e deskisa 
// facem o verificare sa vedem daca este deschisa si daca nu sa deschidem una)

if(!isset($_SESSION)){
session_start();

}

//iar aici salvam in auth userul daca este logat o sa avem true altfel o sa fie false
$auth = $_SESSION["login"]?? false;

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    
    <header class="header <?php echo $inicio ? 'inicio': ''; ?> ">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/index.php">
                    <img src="/build/img/logo.svg" alt="Logotipo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg">
                    <nav class="navegacion">
                   
                        <a href="nosotros.php">Nosotros</a>
                        <a href="anuncios.php">Anuncios</a>
                        <a href="blog.php">Blog</a>
                        <a href="contacto.php">Contacto</a>
                        <?php if($auth){  ?>
                        <a href="cerrar-sesion.php">Cerrar session</a>
                    <?php  
                $_SESSION["login"]=false;
                } ?>
                    </nav>
                </div>
                
            </div> <!--.barra-->
            <?php echo $inicio ? '<h3>Ventas de Casa y Departamentos Exclusivos de Lujo</h3> ':""; ?>
           


        </div>
    </header>
