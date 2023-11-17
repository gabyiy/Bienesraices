<?php

use App\Vendedor;

$vendedor = new Vendedor;


?>

<fieldset>
        <legend>Registrar Vendedor(a)</legend>
        <label for="nombre">Nombre :</label>    

        <!-- folosim functia s pentru a sanitiza(ea se afla in functions) -->

        <!-- folosim propridad[] ,pentru a adaugam de forma automata datele intrun array -->
        <input type="text" id="nombre" name="vendedor[nombre]" value="<?php  echo s( $vendedor->nombre); ?>" placeholder="Nombre vendedor">

        <label for="apellido">Apellido :</label>    

<input type="text" id="apellido" name="vendedor[apellido]" value="<?php  echo s( $vendedor->apellido); ?>" placeholder="Nombre vendedor">

    </fieldset>
    <fieldset>
        <legend>Informacion adicional</legend>

        <label for="telefono">Telefono :</label>    

<input type="text" id="telefono" name="vendedor[telefono]" value="<?php  echo s( $vendedor->telefono); ?>" placeholder="Telefono vendedor">

    </fieldset>

