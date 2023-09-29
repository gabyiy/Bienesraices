<?php
//facem requeri pentru a aveam accest la ce avem in app.php
require "app.php";
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