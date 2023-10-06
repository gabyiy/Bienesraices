<?php

namespace App;

class Propriedad{
    //aici creem toate atributele care le avem la tabla prorpiedades
     public $id;
     public $titulo;
     public $precio;
     public $imagen;
     public $descripcion;
     public $habitaciones;
     public $wc;
     public $estacionamiento;
     public $creado;
     public $vendedores_id;

     //si aici facem functia contruuctor pe care o vom utiliza pentru a acessa datele
     //punem args  care o sa fie un array
     public function __construct($args =[])
     {
        //si asa adaugam datele in constrcutor, si in caz ca nu avem date poate fi un string gol
        $this -> id = $$args["id"]??'';
        $this-> id = $args["titulo"]??'';
        $this-> precio = $args["precio"]??'';
        $this -> imagen = $args["imagen"]??'';
        $this -> descripcion = $args["descripcion"]??'';
        $this -> habitaciones= $args["habitaciones"]??'';
        $this -> wc = $args["wc"]??'';
        $this -> estacionamiento= $args["estacionamiento"]??'';
        $this -> creado = $args["creado"]??'';
        $this ->vendedores_id = $args["vendedores_id"]??'';
     }
}
?>