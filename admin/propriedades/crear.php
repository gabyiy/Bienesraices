<?php
//base de datos

require "../../includes/app.php";


//acum avand acces la app.php putem utiliza si clasa app
use App\Propriedad;
use App\Vendedor;

//intervention o folosim ca sa adaugam imagini
use Intervention\Image\ImageManagerStatic as Image;

//iar aici folosim functia care verifica daca userul este autetificat
 estaAuteticado();



 $propriedad = new Propriedad();


 //Consulta pentru a obtine toti vanzatory 
$vendedores = Vendedor::all();


// $delquery= "DELETE  FROM propriedades";

// $delResultado = mysqli_query($db,$delquery);

// if($delResultado){
//     echo "sau sters";
// }


incluirTemplate("header");

//aici accesam clasa proprieda pentru a avea acces la errores, nu e nevoie sa instantiem cu new fiind protected
$errores = Propriedad::getErrores();



// FI atent cum scri datele

//folosim server pentru a obtine mai detaliate cand folosi var_dump($_FILES, sau $_POST)
if($_SERVER["REQUEST_METHOD"]=== "POST"){

    //instantiem clasa propriedad pentru a avea acces la functiile ei
    //si in acelasi timp le trecem si parametru post cu ce primim din arrayul propriedad din formular
    $propriedad = new Propriedad($_POST['propriedad']);


//creem un folder pentru imagini


//aici generam un nume unic pentru a il da imagini

$nombreImagen =md5(uniqid(rand(),true)) . ".jpg";



//Urcam imaginea si ii face un resize cu intervention  
//imaginea o aducem cum superglobala $_files  iar ca primu parametru punem de unde o luam adica unde are numele image
//iar al doilea parametru este numele temporal
//iar dupa utilizam functia predefinita fit care face ca imaginea sa nu depasesca o anumita capacitate de ex 500 kb
//si ca parametru spunem ca vrea sa aibee 800 px inaltime cu 600 latime
if ($_FILES['propriedad']['tmp_name']['imagen']){
$image =  Image::make($_FILES['propriedad']['tmp_name']['imagen'])->fit(800,600);
//iar aici folosim functia creata in propriedades pentru a trimite imaginea ca parametru care este nombreimagen
$propriedad->setImagen($nombreImagen);

}

//aici utilizam metoda  validar
$errores= $propriedad->validar();

//revizam ca nu avem nici o erroare

if(empty($errores)){
    //daca nu avem erroare urcam imaginea la servidor
    
    //acesam functia guardar care o sa ne adauge proprietatea de forma automata
    

// si aici aspunem ca daca ne este creat folderul din funciones ca sa il creeze
if (!is_dir(CARPETA_IMAGENES)){
    mkdir(CARPETA_IMAGENES);
}

//Salvam destinatia unei imagini intro variabila

//Salvam imaginea in server
$image->save(CARPETA_IMAGENES . $nombreImagen);

//folosim exit cand vrem sa oprim fluxu de informati in php(sa verificam datele introdude de ex cu var_dump)
// exit;

//Salvam imaginea in baza de date
$resultado=$propriedad->guardar();


}
}

$inicio=true;


?>
   <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin/index.php" class="boton boton-verde">Volver al index</a>

        <?php 
        //facem for echo ca sa faca un loop prin toate ororile
     foreach($errores as $error): ?>
     <div class="alerta error"><?php echo  $error ;?></div>
   
      <?php endforeach ;?>
      <!-- pentru a adauga fisiere imagini etc adaugam la formular enctype -->
        <form method="POST" action="/admin/propriedades/crear.php" class="formulario" enctype="multipart/form-data">
      
        <!-- aici adaugam formularul care il avem in tamplate -->

        <?php include "../../includes/templates/formulario_propriedades.php"?>
       <input type="submit" value="Crear Proprieda" class="boton boton-verde">
        </form>
    </main>

    <?php
incluirTemplate("footer");
?>