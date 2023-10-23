<fieldset>
        <legend>Informacion general</legend>
        <label for="titulo">Titulo</label>    

        <!-- folosim functia s pentru a sanitiza(ea se afla in functions) -->
        <input type="text" id="titulo" name="titulo" value="<?php


 echo s( $propriedad->titulo); ?>" placeholder="Titulo de la propriedad">
        <label for="precio">Precio</label>    
        <input type="number" id="precio" name="precio" value="<?php echo s( $propriedad->precio );?>" placeholder="Precio Propriedad ">
        <label for="imagen">Imagen</label>    
        <input type="file" id="imagen" name="imagen"  accept="image/jpeg image/png" name="imagen">
    <?php if($propriedad->imagen) {?>
        <img src="/imagenes/<?php echo $propriedad->imagen ?>" class="imagen-small">
     <?php }  ?>

        <label for="descripcion">Descripcion:</label>
        <textarea name="descripcion" id="descripcion"  cols="30" rows="10"><?php echo s($propriedad->descripcion );?></textarea>
       </fieldset>
       <fieldset>
        <legend>Informacion de la propriedad</legend>
        <label for="habitaciones">Habitaciones</label>    
        <input type="number" id="habitaciones" name="habitaciones" value="<?php echo s($propriedad->habitaciones) ;?>" placeholder="Ex: 3"  min="1" max="9">
        <label for="wc">Banos</label>    
        <input type="number" name="wc" id="wc" value="<?php echo s( $wc); ?>" placeholder="Ex: 1" min="1" max="9">
        <label for="estacionamiento">Estacionamiento</label>    
        <input type="number" id="estacionamiento" name="estacionamiento"value="<?php echo s($propriedad->estacionamiento); ?>" placeholder="Ex: 1" min="1" max="9">
       </fieldset>
       <fieldset>
        <legend>Vendedor</legend>
        <select name="vendedorId" id="">
            <option value="">--Selecione--</option>

            <!-- Si aici verificam daca am vrun vendedor (practic ii facem un map-->
            <?php while($vendedor= mysqli_fetch_assoc($resultado) ): ?>
                <!-- iar mai jos spunem daca venderou id este lafel ca cel din baza de date sa ne adauge selected alftel nimic -->
                <option <?php echo $vendedorId ===$vendedor['id']? 'selected':'' ;?> value="<?php echo s( $propriedad->vendedor['id']); ?>">
                        <?php echo $vendedor['nombre']. " ". $vendedor['apellido'];?>
                </option>
            <?php endwhile ; ?>
         
        </select>
       </fieldset>