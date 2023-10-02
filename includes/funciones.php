<?php



//folosim templates  pentru a acesa mai usor ruta header footer ,funciones etc

//Cu __DIR__ specificam ca este un director
define("TEMPLATES_URL",__DIR__ ."/templates");

define("FUNCIONES_URL", __DIR__."funciones.php");
//iar cand utilizam functia asta aducem headeru unde vrem
//iar ca al doilea parametru punem inicio ,care daca nu e prezent sa fie false pe default
function incluirTemplate ($nombre,$inicio=false){
include TEMPLATES_URL . "/$nombre.php";
}


//functia asta o folosim pentru a autetifca userul si ne va retuna un bool
function estaAuteticado() : bool{

    //initiem sesiunea pentr ua avea acces la variabliele salvate in sesion


session_start();

//facem o verificare

$auth = $_SESSION['login'];


if($auth){
return true;
}else{
    return false;
}

}