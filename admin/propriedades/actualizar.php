<?php

use App\Propriedad;
use Intervention\Image\ImageManagerStatic as Image;

require "../../includes/app.php";

estaAuteticado();


//Aici scoatem id pe care il primim din index.php 
$id = $_GET["id"];
//Iar aici ii facem un filter la id pentru a fi sigur ca este de tip int

$id = filter_var($id,FILTER_VALIDATE_INT);


//si daca nu avem un id il redirectionam care admin

if(!$id){
header("Location: /admin");
}

//Instatiem clasa PRoprieda cu functia statica
$propriedad = Propriedad::find($id);


//asa putem vedea ce ce rezultat avem la proprietati
// echo "<pre>";
// var_dump($propriedad);
// echo "</pre>";

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db,$consulta);

$inicio=true;

incluirTemplate("header");
$errores=Propriedad::getErrores();


// FI atent cum scri datele

//folosim server pentru a obtine mai detaliate cand folosi var_dump($_FILES, sau $_POST)
if($_SERVER["REQUEST_METHOD"]=== "POST"){

    //Asignam  ce avem in arrayul propriedad din formular_propriedades
    $args =$_POST["propriedad"];


    $propriedad->sincronizar($args);

    //revizam ca nu avem nici o erroare

    $errores = $propriedad->validar();

//validam upload arhive

$nombreImagen =md5(uniqid(rand(),true)) . ".jpg";


if ($_FILES['propriedad']['tmp_name']['imagen']){
    $image =  Image::make($_FILES['propriedad']['tmp_name']['imagen'])->fit(800,600);
    //iar aici folosim functia creata in propriedades pentru a trimite imaginea ca parametru care este nombreimagen
    $propriedad->setImagen($nombreImagen);
    
    }

if(empty($errores)){

//folosim exit cand vrem sa oprim fluxu de informati in php(sa verificam datele introdude de ex cu var_dump)
 $propriedad->guardar();
 

}
}
?>
   <main class="contenedor seccion">
        <h1>Actualizar</h1>

        <a href="/admin/index.php" class="boton boton-verde">Volver al index</a>

        <?php 
        //facem for echo ca sa faca un loop prin toate ororile
     foreach($errores as $error): ?>
     <div class="alerta error"><?php echo  $error ;?></div>
   
      <?php endforeach ;?>
      <!-- pentru a adauga fisiere imagini etc adaugam la formular enctype -->

      <!-- pentru a trimite datel de la form direct in pagina unde ne aflam scoate action -->
        <form method="POST" class="formulario" enctype="multipart/form-data">
     <?php include "../../includes/templates/formulario_propriedades.php"?>
       <input type="submit" value="Actualiar Propriedad" class="boton boton-verde">
        </form>
    </main>

    <?php
incluirTemplate("footer");
?>