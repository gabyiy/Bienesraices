<?php

namespace App;



class Propriedad extends ActiveRecord{

       //trimitem table catre active record

   protected static $tabla ="propriedades";
  protected static $columnasDB=["id","titulo","precio","imagen","descripcion","habitaciones","wc","estacionamiento","creado","vendedores_id"];


  
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
}
?>