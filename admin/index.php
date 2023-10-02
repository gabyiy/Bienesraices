<?php


require '../../includes/app.php';


//utilizam functia pentru a vedea daca este autentificat ,daca nu il redirectionam catre index
$auth = estaAuteticado();

if(!$auth){
    header("Location :/");
}

//importam conexiunea 
$db = conectarDB();

//scriem queryul
$query = "SELECT * from propriedades";


//scotem datele

$resultadoConsulta = mysqli_query($db,$query);



//si asa scoate mesajul pe care il primim din crear.php , iar daca nu exista sa fie null
$resultado = $_GET["resultado"]?? null;


//fosolim comanda asta pentru a vedea daca primin date de la form de delete proprieda
//si daca am primit o sa salvam variabila intrun id pentru a o utiliza sa stergem acea proprietate

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $id= $_POST["id"];
    //iar aici il transformam in int
    $id=filter_var($id,FILTER_VALIDATE_INT);

    if ($id){
        //Eliminam archiva
        $query =  "SELECT imagen FROM propriedades WHERE id ={$id}";
        $resultado = mysqli_query($db,$query);

        $proprieda =mysqli_fetch_assoc($resultado);

        unlink("../imagenes/".$proprieda["imagen"]);

        //Eliminam proprietatea
    $query = "DELETE  from propriedades WHERE id = {$id}";
    $resultado = mysqli_query($db, $query);
    if($resultado){
        //facem un redirect si in acelasi timp setam resultadu la 3 pe care o sa il utilizam
        //sa comprobam daca este 3 sa ne apara mesaju ca proprietatea a fost stearsa
        header("Location : /admin?resultado=3");
    }

    }
}
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
    <?php elseif(intval($resultado )=== 3):?>
        <p class="alerta exito">Ai sters proprietatea corect</p>

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
                    <form action="" method="POST" class="w-100">

                    <!-- aici folosim un input cu id proprietati pe care dorim sa o eliminam
                 folosim type hidden ca sa ne ascunda input si sa nu apara valoarea -->
                <input type="hidden" name="id" value="<?php  echo $proprieda['id'];?>">
                    <input type="submit" class="boton-rojo-block" value="Eliminar">

            </form>

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