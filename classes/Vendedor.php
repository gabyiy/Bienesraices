<?php
namespace App;


class Vendedor extends ActiveRecord{

    //trimitem table catre active record
    protected static $tabla ="vendedores";
    protected static $columnasDB=['id','nombre','apellido','telefono'];


    
    //aici creem toate atributele care le avem la tabla prorpiedades
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
  
}


?>