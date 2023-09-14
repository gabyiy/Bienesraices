<?php
require "../includes/funciones.php";
$inicio=true;

incluirTemplate("header");
?>
    <main class="contenedor seccion">
        <h1>Adminstrador de bienes raices</h1>
        <a href="/bienesraicesPHP/admin/propriedades/crear.php" class="boton boton-verde">Crear</a>
    </main>

    <?php
incluirTemplate("footer");
?>