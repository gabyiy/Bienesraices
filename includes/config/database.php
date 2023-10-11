<?php


//functia de conectare care o sa ne returneze msqli in caz ca avem erroare
function conectarDB(): mysqli{
    //si asa facem ca sa ne conectam la mysql dar pentru forma orietata la obiecte
    $db =new  mysqli("localhost","root","root","bienesraices_crud");
    $db->set_charset('utf8'); 

    if(!$db){
        echo "Error not connected";
        //cu var dump ne da toate delaile conexiuni
var_dump($db);
        exit;
    }
    return $db;
}