<?php

namespace App;

use mysqli;

class Propriedad{
//aici creem variabila  pe care o vom utiliza la baza de date ii punem protected ca sa poata fi folosita doar in clasa asta

protected static $db ;
protected static $columnasDB = ['id','titulo','precio','imagen','descripcion','habitaciones','wc','creado','vendedores_id'];


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
        //cand ne referim la variabile publice folosim this si nu punem $ inainte la variabile
        $this -> id = $$args["id"]??'';
        $this-> titulo= $args["titulo"]??'';
        $this-> precio = $args["precio"]??'';
        $this -> imagen = $args["imagen"]??'imagen.jpg';
        $this -> descripcion = $args["descripcion"]??'';
        $this -> habitaciones= $args["habitaciones"]??'';
        $this -> wc = $args["wc"]??'';
        $this -> estacionamiento= $args["estacionamiento"]??'';
        //asa facem ca date sa se ia de forma autmatica fara a introduce noi datele
        $this -> creado = date("Y/m/d")??'';
        $this ->vendedores_id = $args["vendedorId"]??'';
     }

     //cu functia asta asta salvam datele pe care le primim de la functia construc
     public function guardar(){
      //inainte sa salvam fdatele facem o sanitizare

      $atributos = $this->sanitizarAtributos();

      $query = "INSERT INTO propriedades 
      (titulo,precio,imagen,descripcion,habitaciones,wc,estacionamiento,creado,vendedores_id)
     VALUES('$this->titulo','$this->precio','$this->imagen','$this->descripcion','$this->habitaciones','$this->wc','$this->estacionamiento','$this->creado','$this->vendedores_id')";
     
     //iar aici salvam datele cu forma  orientata la obiecte cu methoda query

     $resultado=self::$db->query($query);
     }

     //ca sa utilizam variabila estatice folosim functi estatice si ne referem la variabila cu self
   // la statice punem $ inainte la variabile
     public static function setDB($database){
      self::$db= $database;
     }

     //functia asta se va ocupa de iterarea $columnsDB
     public function atributos (){
$atributos=[];
      foreach(self::$columnasDB as $columna){
         //aici spunem sa ignore id si sa treaca la urmatoarea iterare
         if($columna==="id")continue;
                  //aici iteram fiecare columna ce primim de la columnaDB

         $atributos[$columna]=$this->$columna;
      }
      return $atributos;
      debug($atributos);

     }

     //iar asta se va ocupa de sanitizare 
     public function  sanitizarAtributos(){
      //aici salvam tot ce avem la return in atribuos si acum putem sa incepem sanitazarea
      $atributos = $this->atributos();
      $sanitizando=[];

      //facem un foreach unde vrem sa pastram si keyu si values ,si pentru ca vrem sa utilizam baza de date punem self db
      foreach($atributos as $key => $value){
         $sanitizando[$key]=self::$db->escape_string($value);
      }
     }
}
?>