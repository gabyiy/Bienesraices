<?php
require '../../includes/app.php';

use App\Vendedor;

//folosim functia asta pt ca doar cei care sunt admin pot intra in pagina

estaAuteticado();

$vendeor = new Vendedor;

$errores = Vendedor::getErrores();



// FI atent cum scri datele

//folosim server pentru a obtine mai detaliate cand folosi var_dump($_FILES, sau $_POST)
if($_SERVER["REQUEST_METHOD"]=== "POST"){

    //asa salvam in variabila vendedor ce primim la post ,dar in acelasi timp il salvam si in clasa vendedor
$vendedor = new Vendedor($_POST["vendedor"]);

//Facem o validare ca nu avem  spati goale
$errores=$vendedor->validar();

//daca nu avem errori salvam vendedoru

if (empty($errores)){
  
    $vendedor->guardar();
}
}

incluirTemplate("header");
?>
<main class="contenedor seccion">
<h1>Registrar vendedores</h1>

<a href="/admin/index.php" class="boton boton-verde">Volver al index</a>

<?php 
//facem for echo ca sa faca un loop prin toate ororile
foreach($errores as $error): ?>
<div class="alerta error"><?php echo  $error ;?></div>

<?php endforeach ;?>
<!-- pentru a adauga fisiere imagini etc adaugam la formular enctype -->
<form method="POST" action="/admin/vendedores/crear.php" class="formulario" enctype="multipart/form-data">

<!-- aici adaugam formularul care il avem in tamplate -->

<?php include "../../includes/templates/formulario_vendedores.php"?>
<input type="submit" value="Registrar Vendedor" class="boton boton-verde">
</form>
</main>

