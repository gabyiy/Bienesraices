<?php

//facem requeri pentru a aveam accest la ce avem in app.php
//Practic app contine toate rutele care o sa le folsoim in aplicatie si de acea o nu o sa mai fie nevoie sa le 
//dam requeuire pe rand ci facem doar un requeri la app.php 

require "funciones.php";
require "config/database.php";
require __DIR__ . "/../vendor/autoload.php";


use App\Propriedad;

$propriedad = new Propriedad;
