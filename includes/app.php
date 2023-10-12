<?php

//facem requeri pentru a aveam accest la ce avem in app.php
//Practic app contine toate rutele care o sa le folsoim in aplicatie si de acea o nu o sa mai fie nevoie sa le 
//dam requeuire pe rand ci facem doar un requeri la app.php 

require "funciones.php";
require "config/database.php";
require __DIR__ . "/../vendor/autoload.php";

//Conexiunea la baza de date
$db =conectarDB();

$db = conectarDB();
use App\Propriedad;


//Fiind o functie statica nu trebuie instantiata, iar dupa ii trecem ca parametru conexiunea
Propriedad::setDB($db);
