<?php
//base de datos

require "../../includes/app.php";


//acum avand acces la app.php putem utiliza si clasa app
use App\Propriedad;

//intervention o folosim ca sa adaugam imagini
use Intervention\Image\ImageManagerStatic as Image;

//iar aici folosim functia care verifica daca userul este autetificat
 estaAuteticado();


 $db = conectarDB();

//Consultam sa vedem ce vanzatori avem

$consulta = "SELECT * FROM  vendedores";

$resultado = mysqli_query($db,$consulta);


// $delquery= "DELETE  FROM propriedades";

// $delResultado = mysqli_query($db,$delquery);

// if($delResultado){
//     echo "sau sters";
// }


// incluirTemplate("header");

//aici accesam clasa proprieda pentru a avea acces la errores, nu e nevoie sa instantiem cu new fiind protected
$errores = Propriedad::getErrores();


$titulo = "";
$precio = "";
$descripcion = "";
$habitaciones = "";
$wc = "";
$estacionamiento = "";
$vendedorId = "";



// FI atent cum scri datele

//folosim server pentru a obtine mai detaliate cand folosi var_dump($_FILES, sau $_POST)
if($_SERVER["REQUEST_METHOD"]=== "POST"){

    //instantiem clasa propriedad pentru a avea acces la functiile ei
    //si in acelasi timp le trecem si parametru post
    $propridad = new Propriedad($_POST);


//creem un folder pentru imagini


//aici generam un nume unic pentru a il da imagini

$nombreImagen =md5(uniqid(rand(),true)) . ".jpg";



//Urcam imaginea si ii face un resize cu intervention  
//imaginea o aducem cum superglobala $_files  iar ca primu parametru punem de unde o luam adica unde are numele image
//iar al doilea parametru este numele temporal
//iar dupa utilizam functia predefinita fit care face ca imaginea sa nu depasesca o anumita capacitate de ex 500 kb
//si ca parametru spunem ca vrea sa aibee 800 px inaltime cu 600 latime
if ($_FILES['imagen']['tmp_name']){
$image =  Image::make($_FILES['imagen']['tmp_name'])->fit(800,600);
//iar aici folosim functia creata in propriedades pentru a trimite imaginea ca parametru care este nombreimagen

$propriedad->setImagen($nombreImagen);

}

//aici utilizam metoda  validar
$errores= $propridad->validar();

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
$resultado=$propridad->guardar();

//Mesaj de succes sau fail
if($resultado){
    //Daca totu este ok facem un redirect iar dupa ce punem ? putem trimite date care
    //pot fi citite in locatia unde facem redirect ,iar cu & putem adauga mai multe mesajr
    header('Location: /admin?resultado=1');
}
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
       <fieldset>
        <legend>Informacion general</legend>
        <label for="titulo">Titulo</label>    
        <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>" placeholder="Titulo de la propriedad">
        <label for="precio">Precio</label>    
        <input type="number" id="precio" name="precio" value="<?php echo $precio ;?>" placeholder="Precio Propriedad ">
        <label for="imagen">Imagen</label>    
        <input type="file" id="imagen" name="imagen"  accept="image/jpeg image/png" name="imagen">
        <label for="descripcion">Descripcion:</label>
        <textarea name="descripcion" id="descripcion"  cols="30" rows="10"><?php echo $descripcion ;?></textarea>
       </fieldset>
       <fieldset>
        <legend>Informacion de la propriedad</legend>
        <label for="habitaciones">Habitaciones</label>    
        <input type="number" id="habitaciones" name="habitaciones" value="<?php echo $habitaciones ;?>" placeholder="Ex: 3"  min="1" max="9">
        <label for="wc">Banos</label>    
        <input type="number" name="wc" id="wc" value="<?php echo $wc ?>" placeholder="Ex: 1" min="1" max="9">
        <label for="estacionamiento">Estacionamiento</label>    
        <input type="number" id="estacionamiento" name="estacionamiento"value="<?php echo $estacionamiento; ?>" placeholder="Ex: 1" min="1" max="9">
       </fieldset>
       <fieldset>
        <legend>Vendedor</legend>
        <select name="vendedorId" id="">
            <option value="">--Selecione--</option>

            <!-- Si aici verificam daca am vrun vendedor (practic ii facem un map-->
            <?php while($row= mysqli_fetch_assoc($resultado) ): ?>
                <!-- iar mai jos spunem daca venderou id este lafel ca cel din baza de date sa ne adauge selected alftel nimic -->
                <option <?php echo $vendedorId ===$row['id']? 'selected':'' ;?> value="<?php echo $row['id']; ?>">
                        <?php echo $row['nombre']. " ". $row['apellido'];?>
                </option>
            <?php endwhile ; ?>
         
        </select>
       </fieldset>
       <input type="submit" value="Crear Proprieda" class="boton boton-verde">
        </form>
    </main>

    <?php
incluirTemplate("footer");
?>