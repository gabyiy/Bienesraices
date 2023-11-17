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


    public function __construct($args =[])
    {
       //si asa adaugam datele in constrcutor, si in caz ca nu avem date poate fi un string gol
       //cand aveam functi publice folosim this
       $this -> id = $$args["id"]??'';
       $this-> titulo = $args["titulo"]??'';
       $this-> precio = $args["precio"]??'';
       $this -> imagen = $args["imagen"]??'';
       $this -> descripcion = $args["descripcion"]??'';
       $this -> habitaciones= $args["habitaciones"]??'';
       $this -> wc = $args["wc"]??'';
       $this -> estacionamiento= $args["estacionamiento"]??'';
       //facem asta ca sa isi ia data de forma automata
       $this -> creado = date("Y/m/d")??'';
       $this ->vendedores_id =      $args["vendedorId"]??"";
       ;
    }
    //folosim this pentru a accesa variabilele din clasa , iar cu self accesam variabila protected errors
public function validar(){

  if(!$this->titulo){
     self::$errores[]= "Trebuie sa adaugi un titlu";
     
     }
     
     if(!$this->precio){
         self::$errores[]= "Trebuie sa adaugi un pret";
     
         }
         if(strlen( $this->descripcion)<40){
             self::$errores[]= "Trebuie sa adaugi o descriptie si trebuie sa fie mai mare de 50 caractere";
         
             }
     
         if(!$this->habitaciones){
             self::$errores[]= "Trebuie sa adaugi un numar de camere";
         
             }
             if(!$this->wc){
                 self::$errores[]= "Trebuie sa adaugi un numar de toalete";
             
                 }
                 if(!$this->estacionamiento){
                     self::$errores[]= "Trebuie sa adaugi un numar de parcari";
                 
                     }
                     if(!$this->vendedores_id){
                         self::$errores[]= "Trebuie sa adauginumele vanzatorului";
                     
                         }
     //asa verificam daca itroducem o imagine(cu var_dump($_FILE) aflam daca are un nume in arrayul imagini)
     //punem imagen error pt ca in caza ca depasete 2 mega mysql o sa ne dea errore
     if (!$this->imagen){
     self::$errores[]="Trebuie introdusa o imagine a proprietati";
     }
     return self::$errores;
}

//Listeaza toate proprietatilie
//facem o functie dinamica care poate primi diferite consulte

//si functile care urmeaza fac urmatoarele (transforma dintru array intrun obiect ,pentru ca asa functioneaza active record)
public static function all (){
//asa adaugam de forma  dinamica ce vrem sa caute (care poate fi atat table de la vendedor cat s ide la propriedades)
$query ="SELECT  * FROM " . static::$tabla;

$resultado =self::consultarSQL($query);

return $resultado;


}
}
?>