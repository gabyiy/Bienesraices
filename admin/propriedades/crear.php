<?php
//base de datos

require "../../includes/config/database.php";
$db =conectarDB();



require "../../includes/funciones.php";
$inicio=true;

incluirTemplate("header");



//Insertam in baza de date
$titulo = $_POST["titulo"];
$precio = $_POST["precio"];
$descripcion = $_POST["descricion"];
$habitaciones = $_POST["habitaciones"];
$wc = $_POST["wc"];
$estacionamiento = $_POST["estacionamiento"];
$vendedorId = $_POST["vendedor"];

$query = "INSERT INTO propriedades 
 (titulo,precio,descripcion,habitaciones,wc,estacionamiento,vendedores_id)
VALUES('$titulo','$precio','$descripcion','$habitaciones','$wc','$estacionamiento','$vendedorId')";



$resultado = mysqli_query($db, $query);


if($resultado){
    echo "Insertado corectamente";
}else {
    echo " No se a insertado corectamente";
}

?>
    <main class="contenedor seccion">
        <h1>Crear</h1>
        <a href="/bienesraicesPHP/admin/index.php" class="boton boton-verde">Volver al index</a>

        <form method="POST" action="/bienesraicesPHP/admin/propriedades/crear.php" class="formulario">
       <fieldset>
        <legend>Informacion general</legend>
        <label for="titulo">Titulo</label>    
        <input type="text" id="titulo" name="titulo" placeholder="Titulo de la propriedad">
        <label for="precio">Precio</label>    
        <input type="number" id="precio" name="precio" placeholder="Precio Propriedad ">
        <label for="imagen">Imagen</label>    
        <input type="file" id="imagen" name="imagen" accept="image/jpeg image/png">
        <label for="descripcion">Descripcion:</label>
        <textarea name="descripcion" id="descripcion" cols="30" rows="10"></textarea>
       </fieldset>
       <fieldset>
        <legend>Informacion de la propriedad</legend>
        <label for="habitaciones">Habitaciones</label>    
        <input type="number" id="habitaciones" name="habitaciones" placeholder="Ex: 3"  min="1" max="9">
        <label for="wc">Banos</label>    
        <input type="number" name="wc" id="wc" placeholder="Ex: 1" min="1" max="9">
        <label for="estacionamiento">Estacionamiento</label>    
        <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ex: 1" min="1" max="9">
       </fieldset>
       <fieldset>
        <legend>Vendedor</legend>
        <select name="vendedorId" id="">
            <option value="1">Gabriel</option>
        <option value="2">Karen</option>
        </select>
       </fieldset>
       <input type="submit" value="Crear Proprieda" class="boton boton-verde">
        </form>
    </main>

    <?php
incluirTemplate("footer");
?>