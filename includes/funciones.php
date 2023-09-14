<?php
//facem requeri pentru a aveam accest la ce avem in app.php
require "app.php";
//iar cand utilizam functia asta aducem headeru unde vrem
//iar ca al doilea parametru punem inicio ,care daca nu e prezent sa fie false pe default
function incluirTemplate ($nombre,$inicio=false){
include TEMPLATES_URL . "/$nombre.php";
}