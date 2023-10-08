<?php
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

//base de datos

$db =conectarDB();

//Consultam sa vedem ce vanzatori avem

$consulta = "SELECT * FROM  propriedades where id ={$id}" ;
$resultado = mysqli_query($db,$consulta);

$propriedad = mysqli_fetch_assoc($resultado);


//asa putem vedea ce ce rezultat avem la proprietati
// echo "<pre>";
// var_dump($propriedad);
// echo "</pre>";

$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db,$consulta);

$inicio=true;

incluirTemplate("header");
$errores=[];

//Iar asa putem sa le trecem ca date ce avem salvat in propriedad
$titulo = $propriedad["titulo"];
$precio = $propriedad["precio"];
$descripcion = $propriedad["descripcion"];
$habitaciones = $propriedad["habitaciones"];
$wc = $propriedad["wc"];
$estacionamiento = $propriedad["estacionamiento"];
$vendedorId = $propriedad["vendedores_id"];
$imagenPropriedad = $propriedad["imagen"];



// FI atent cum scri datele

//folosim server pentru a obtine mai detaliate cand folosi var_dump($_FILES, sau $_POST)
if($_SERVER["REQUEST_METHOD"]=== "POST"){


    // FI atent cum scri datele

//Insertam in baza de date

//folosim mysqli_real_escape pentr ua face datele mai sigure
$titulo = mysqli_real_escape_string($db,$_POST["titulo"]);
$precio = mysqli_real_escape_string($db,$_POST["precio"]);
$descripcion = mysqli_real_escape_string($db,$_POST["descripcion"]);
$habitaciones = mysqli_real_escape_string($db,$_POST["habitaciones"]);
$wc = mysqli_real_escape_string($db,$_POST["wc"]);
$estacionamiento = mysqli_real_escape_string($db,$_POST["estacionamiento"]);
$vendedorId = mysqli_real_escape_string($db,$_POST["vendedorId"]);
$creado =date("Y/m/d");

//Salvam destinatia unei imagini intro variabila

$imagen = $_FILES["imagen"];


if(!$titulo){
$errores[]= "Trebuie sa adaugi un titlu";

}

if(!$precio){
    $errores[]= "Trebuie sa adaugi un pret";

    }
    if(strlen( $descripcion)<40){
        $errores[]= "Trebuie sa adaugi o descriptie si trebuie sa fie mai mare de 50 caractere";
    
        }

    if(!$habitaciones){
        $errores[]= "Trebuie sa adaugi un numar de camere";
    
        }
        if(!$wc){
            $errores[]= "Trebuie sa adaugi un numar de toalete";
        
            }
            if(!$estacionamiento){
                $errores[]= "Trebuie sa adaugi un numar de parcari";
            
                }
                if(!$vendedorId){
                    $errores[]= "Trebuie sa adauginumele vanzatorului";
                
                    }

//Aici validim pentru marime ,sa nu depasesca o anumita marime
// medida ar fi 100kb ar fi marimea maxima
$medida = 1000 *100;

if ($imagen["size"] >$medida ){
    $errores[]="Imaginea este prea mare";
}
                    
//revizam ca nu avem nici o erroare

if(empty($errores)){
//daca nu avem erroare urcam imaginea la servidor

//creem un folder

$carpetaImagenes = "../../imagenes/";

if(!is_dir($carpetaImagenes)){
mkdir($carpetaImagenes);
}

//asta o sa il folosim mai incolo in cazaca nu am adaugat o imagine
$nombreImagen="";

if($imagen["name"]){
//Elminam imaginea existenta pentru a o actualiza cu cea noua


unlink($carpetaImagenes . $propriedad['imagen']);

//aici generam un nume unic pentru a il da imagini
$nombreImagen =md5(uniqid(rand(),true)) .".jpg";

//Urcam imaginea
//selectioname numele temporal al variabilei(pentru a idetifica imaginea) dupa specificam unde
// vrem sa o salvez iar al treilea parametru este numele
move_uploaded_file($imagen["tmp_name"],$carpetaImagenes. $nombreImagen);
}else{
    //aici spunem ca numele imagini sa raman ce aveam salvat la propiedad imagine 
    //sa nu se schimbe si nici sa se stearga
    $nombreImagen = $propriedad["imagen"];
}
//folosim exit cand vrem sa oprim fluxu de informati in php(sa verificam datele introdude de ex cu var_dump)
// exit;

//punem '' doar unde avem string unde avem int lasa doar variabila
//este bine sa comprobam upatu in tableplus
$query = "UPDATE propriedades SET titulo = '{$titulo}',precio = {$precio},imagen = '{$nombreImagen}',descripcion = '{$descripcion}',
habitaciones = {$habitaciones}, wc = {$wc},estacionamiento = {$estacionamiento},vendedores_id ={$vendedorId} WHERE id={$id}";


$resultado = mysqli_query($db, $query);
 

if($resultado){
    //Daca totu este ok facem un redirect iar dupa ce punem ? putem trimite date care
    //pot fi citite in locatia unde facem redirect ,iar cu & putem adauga mai multe mesajr
    header('Location: /admin?resultado=2');
}
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
       <fieldset>
        <legend>Informacion general</legend>
        <label for="titulo">Titulo</label>    
        <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>" placeholder="Titulo de la propriedad">
        <label for="precio">Precio</label>    
        <input type="number" id="precio" name="precio" value="<?php echo $precio ;?>" placeholder="Precio Propriedad ">
        <label for="imagen">Imagen</label>    
        <input type="file" id="imagen" name="imagen"  accept="image/jpeg image/png" name="imagen">
        <img src="/imagenes/<?php echo $imagenPropriedad?>" class="imagen-small" alt="">
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
       <input type="submit" value="Actualiar Propriedad" class="boton boton-verde">
        </form>
    </main>

    <?php
incluirTemplate("footer");
?>