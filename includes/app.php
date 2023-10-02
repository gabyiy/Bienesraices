<?php

//facem requeri pentru a aveam accest la ce avem in app.php

require "funciones.php";
require "config/database.php";
require __DIR__ . "/../vendor/autoload.php";


use App\Propriedad;

$propriedad = new Propriedad;
