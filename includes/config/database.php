<?php


//functia de conectare care o sa ne returneze msqli in caz ca avem erroare
function conectarDB(): mysqli{
    //folosim forma orientata la obiecte pentru a realiza conexiunea parola este admin sau root
    $db = new mysqli("localhost","root","admin","bienesraices_crud");
    $db->set_charset('utf8'); 

    if(!$db){
        echo "Error not connected";
        //cu var dump ne da toate delaile conexiuni
var_dump($db);
        exit;
    }
    return $db;
}