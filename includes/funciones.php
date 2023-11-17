<?php



//folosim templates  pentru a acesa mai usor ruta header footer ,funciones etc

//Cu __DIR__ specificam ca este un director
define("TEMPLATES_URL",__DIR__ ."/templates");

define("FUNCIONES_URL", __DIR__."funciones.php");
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');



//iar cand utilizam functia asta aducem headeru unde vrem
//iar ca al doilea parametru punem inicio ,care daca nu e prezent sa fie false pe default
function incluirTemplate ($nombre,$inicio=false){
include TEMPLATES_URL . "/$nombre.php";
}


//functia asta o folosim pentru a autetifca userul si ne va retuna un bool
function estaAuteticado() {

    //initiem sesiunea pentr ua avea acces la variabliele salvate in sesion


session_start();

//facem o verificare




if($_SESSION['login']){
    header("Location: /admin");
}

}


//asta este o functie pe care o vom folosim ca scorcut de var_dump

function debug ($input){

echo "<pre>";
var_dump($input);
echo "</pre>";
exit;
}


//Escape sanitize  HTML

function s ($html):string{

$s =htmlspecialchars($html);
return $s;
}

//validar tipo de contenido

function validarTipoContenido ($tipo){
$tipos = ["vendedor","proprieda"];
//asa specicam ce sa caute si unde sa caute
return in_array($tipo,$tipos);
}