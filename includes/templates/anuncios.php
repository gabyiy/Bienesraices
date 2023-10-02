<?php

$inicio=true;

$db =conectarDB();


//si aici acesam variabila trimisa din index .php
$query = "SELECT * FROM propriedades LIMIT {$limite}";
$resultado = mysqli_query($db, $query);


?>



        <div class="contenedor-anuncios">
            <?php while( $proprieda = mysqli_fetch_assoc($resultado)): ?>
            <div class="anuncio">
                <picture>
                    <!-- <source srcset="build/img/anuncio1.webp" type="image/webp">
                    <source srcset="build/img/anuncio1.jpg" type="image/jpeg"> -->
                    <img loading="lazy" src="/imagenes/<?php echo $proprieda["imagen"]?>" alt="anuncio">
                </picture>

                <div class="contenido-anuncio">
                    <h3><?php echo $proprieda["titulo"]?></h3>
                    <p><?php echo $proprieda["descripcion"]?></p>
                    <p class="precio"><?php echo $proprieda["precio"] ?></p>

                    <ul class="iconos-caracteristicas">
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                            <p><?php echo $proprieda["wc"]?></p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                            <p><?php $proprieda["estacionamiento"]?></p>
                        </li>
                        <li>
                            <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                            <p><?php echo $proprieda["habitaciones"]?></p>
                        </li>
                    </ul>

                    <a href="anuncio.php?id=<?php echo  $proprieda['id']?>" class="boton-amarillo-block">
                        Ver Propiedad
                    </a>
                </div><!--.contenido-anuncio-->
            </div><!--anuncio-->
            <?php endwhile; ?>
            </div>

    <?php
    // Inchidem conexiunea
    mysqli_close($db);
?>