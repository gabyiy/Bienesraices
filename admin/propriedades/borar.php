<?php
require "../../includes/funciones.php";
require "../../includes/config/database.php";

$db = conectarDB();




$inicio=true;

incluirTemplate("header");
?>
    <main class="contenedor seccion">
        <h1>Titulo Página</h1>
    </main>

    <?php
incluirTemplate("footer");
?>