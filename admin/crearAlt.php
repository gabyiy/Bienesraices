<?php
//base de datos

require "../../includes/config/database.php";
$db =conectarDB();

//Consultam sa vedem ce vanzatori avem

$consulta = "SELECT * FROM  vendedores";


$resultado = mysqli_query($db,$consulta);


// $delquery= "DELETE  FROM propriedades";

// $delResultado = mysqli_query($db,$delquery);

// if($delResultado){
//     echo "sau sters";
// }

require "../../includes/funciones.php";
$inicio=true;

incluirTemplate("header");
$errores=[];


$titulo = "";
$precio = "";
$descripcion = "";
$habitaciones = "";
$wc = "";
$estacionamiento = "";
$vendedorId = "";



// FI atent cum scri datele
if($_SERVER["REQUEST_METHOD"]=== "POST"){


    // FI atent cum scri datele

//Insertam in baza de date
$titulo = $_POST["titulo"];
$precio = $_POST["precio"];
$descripcion = $_POST["descripcion"];
$habitaciones = $_POST["habitaciones"];
$wc = $_POST["wc"];
$estacionamiento = $_POST["estacionamiento"];
$vendedorId = $_POST["vendedorId"];
$creado =date("Y/m/d");


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




                    
//revizam ca nu avem nici o erroare


if(empty($errores)){
$query = "INSERT INTO propriedades 
 (titulo,precio,descripcion,habitaciones,wc,estacionamiento,creado,vendedores_id)
VALUES('$titulo','$precio','$descripcion','$habitaciones','$wc','$estacionamiento','$creado','$vendedorId')";


$resultado = mysqli_query($db, $query);

if($resultado){
    //Daca totu este ok facem un redirect
    header('Location: /admin');
}
}
}
?>
   <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin/index.php" class="boton boton-verde">Volver al index</a>

        <?php 
        //facem for echo ca sa faca un loop prin toate ororile
     foreach($errores as $error): ?>
     <div class="alerta error"><?php echo  $error ;?></div>
   
      <?php endforeach ;?>
        <form method="POST" action="/admin/propriedades/crear.php" class="formulario">
       <fieldset>
        <legend>Informacion general</legend>
        <label for="titulo">Titulo</label>    
        <input type="text" id="titulo" name="titulo" value="<?php echo $titulo; ?>" placeholder="Titulo de la propriedad">
        <label for="precio">Precio</label>    
        <input type="number" id="precio" name="precio" value="<?php echo $precio ;?>" placeholder="Precio Propriedad ">
        <label for="imagen">Imagen</label>    
        <input type="file" id="imagen" name="imagen"  accept="image/jpeg image/png">
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