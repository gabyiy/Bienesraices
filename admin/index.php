<?php


require '../includes/app.php';


//utilizam functia pentru a vedea daca este autentificat ,daca nu il redirectionam catre index
//folosim acelasi sistem pentru a proteja actualizar.php si creaer (practic doar daca este autetificat poate vedea paginile
//altfel va fi redirectionat catre ruta home)
 estaAuteticado();

use App\Propriedad;
use App\Vendedor;

//Implementam  o metododa pentru a extrage toate proprietatile utilizand active record

$vendedores = Vendedor::all();
$propriedades = Propriedad::all();

//scotem datele




//si asa scoate mesajul pe care il primim din crear.php , iar daca nu exista sa fie null
$resultado = $_GET["resultado"]?? null;


//fosolim comanda asta pentru a vedea daca primin date de la form de delete proprieda
//si daca am primit o sa salvam variabila intrun id pentru a o utiliza sa stergem acea proprietate

if($_SERVER["REQUEST_METHOD"]==="POST"){
    $id= $_POST["id"];
    //iar aici il transformam in int
    $id=filter_var($id,FILTER_VALIDATE_INT);

    //aici facem diferenta de ce primim la post (fie name propriedad sau vendedor ),asa putem sterge
    //ori proprietatea ori vanzatoru


    $tipo = $_POST['tipo'];

    if(validarTipoContenido($tipo)){

    if($tipo=="proprieda"){
        $proprieda = Propriedad::find($id);

        $proprieda->eliminar();
    }elseif($tipo=="vendedor"){
        $vendedor= Vendedor::find($id);
        $vendedor->eliminar();
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
        <a href="/admin/propriedades/crear.php" class="boton boton-verde">Nueva Propriedad</a>
        <a href="/admin/vendedores/crear.php" class="boton boton-amarillo">Nuevo(a) Vendedor</a>

        <h2>Propriedades</h2>
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
        <!-- Monstram datele care sunt salvate intru obict( de asta folosim foreach)-->
        <tbody>
            <?php foreach($propriedades as $propriedad): ?>

            <tr>
                <td><?php echo $propriedad->id;?></td>
                <td><?php echo $propriedad->titulo; ?></td>
                <td><img src="../imagenes/<?php echo  $propriedad->imagen;?>" class="imagen-tabla" alt=""></td>
                <td><?php echo $propriedad->precio;?></td>
                <td>
                    <form action="" method="POST" class="w-100">

                    <!-- aici folosim un input cu id proprietati pe care dorim sa o eliminam
                 folosim type hidden ca sa ne ascunda input si sa nu apara valoarea -->
                <input type="hidden" name="id" value="<?php  echo $propriedad->id;?>">
                <input type="hidden" name="tipo" value="proprieda">

                    <input type="submit" class="boton-rojo-block" value="Eliminar">

            </form>

                    <!-- Asa specificam la proprieda vrem sa merge ca sa actualizam trecandui idul -->
                    <a href="/admin/propriedades/actualizar.php?id=<?php echo $propriedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
        </td>
            </tr>
            <?php endforeach; ?>

        </tbody>
        </table>
        <h2>Vendedores</h2>
        <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Telefono</th>
                <th>Acciones</th>
             

        </tr>

        </thead>
        <!-- Monstram datele care sunt salvate intru obict( de asta folosim foreach)-->
        <tbody>
            <?php foreach($vendedores as $vendedor): ?>

            <tr>
                <td><?php echo $vendedor->id;?></td>
                <td><?php echo $vendedor->nombre . $vendedor->apellido; ?></td>
                <td><?php echo $vendedor->telefono; ?></td>

                <td>
                    <form action="" method="POST" class="w-100">

                    <!-- aici folosim un input cu id proprietati pe care dorim sa o eliminam
                 folosim type hidden ca sa ne ascunda input si sa nu apara valoarea -->
                <input type="hidden" name="id" value="<?php  echo $propriedad->id;?>">
                <input type="hidden" name="tipo" value="vendedor">

                    <input type="submit" class="boton-rojo-block" value="Eliminar">

            </form>

                    <!-- Asa specificam la proprieda vrem sa merge ca sa actualizam trecandui idul -->
                    <a href="/admin/vendedores/actualizar.php?id=<?php echo $propriedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
        </td>
            </tr>
            <?php endforeach; ?>

        </tbody>
        </table>

    </main>

    
    <?php


incluirTemplate("footer");
?>