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


}

incluirTemplate("header");
?>
<main class="contenedor seccion">
<h1>Actualizar vendedores(a)</h1>

<a href="/admin/index.php" class="boton boton-verde">Volver al index</a>

<?php 
//facem for echo ca sa faca un loop prin toate ororile
foreach($errores as $error): ?>
<div class="alerta error"><?php echo  $error ;?></div>

<?php endforeach ;?>
<!-- pentru a adauga fisiere imagini etc adaugam la formular enctype -->
<form method="POST" action="/admin/vendedores/actualizar.php" class="formulario" enctype="multipart/form-data">

<!-- aici adaugam formularul care il avem in tamplate -->

<?php include "../../includes/templates/formulario_vendedores.php"?>
<input type="submit" value="Guardar cambios " class="boton boton-verde">
</form>
</main>

