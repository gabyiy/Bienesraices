<?php


require "../includes/funciones.php";
require '../includes/config/database.php';
//importam conexiunea 
$db = conectarDB();

//scriem queryul
$query = "SELECT * from propriedades";


//scotem datele

$resultadoConsulta = mysqli_query($db,$query);



//si asa scoate mesajul pe care il primim din crear.php , iar daca nu exista sa fie null
$resultado = $_GET["resultado"]?? null;

$inicio=true;

incluirTemplate("header");
?>
    <main class="contenedor seccion">
        <h1>Adminstrador de bienes raices</h1>
        <!-- si aici verificam daca resultao este 1 sa trimitem mesaju ,dar mai intai il facem de tip int-->
        <?php if(intval( $resultado)===1):?>

            <p class="alerta exito">Ai introdus datele corect</p>
        <!-- sau daca primim 2 la resultat din actualizar sa ne scrie ca este o actualizare        -->
<?php elseif(intval($resultado)===2): ?>
    
    <p class="alerta exito">Ai modificat datele corect</p>

    <?php endif; ?>
        <a href="/admin/propriedades/crear.php" class="boton boton-verde">Crear</a>
        <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Imagen</th>
                <th></Prog>Pecio</th>
                <th>Aciones</th>

        </tr>

        </thead>
        <!-- Monstram datele -->
        <tbody>
            <?php while(  $proprieda  = mysqli_fetch_assoc($resultadoConsulta)): ?>

            <tr>
                <td><?php echo $proprieda["id"] ?></td>
                <td><?php echo $proprieda["titulo"] ?></td>
                <td><img src="../imagenes/<?php echo  $proprieda["imagen"]?>" class="imagen-tabla" alt=""></td>
                <td><?php echo $proprieda["precio"] ?></td>
                <td>
                    <a href="" class="boton-rojo-block">Eliminar</a>

                    <!-- Asa specificam la proprieda vrem sa merge ca sa actualizam trecandui idul -->
                    <a href="/admin/propriedades//actualizar.php?id=<?php echo $proprieda["id"]; ?>" class="boton-amarillo-block">Actualizar</a>
        </td>
            </tr>
            <?php endwhile; ?>

        </tbody>
        </table>
    </main>

    
    <?php

    // Inchidem conexiunea
    mysqli_close($db);
incluirTemplate("footer");
?>