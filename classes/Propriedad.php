<?php

namespace App;



class Propriedad{
//Variabila bazei de date care o facem protected ca sa fie accesibila doar din clasa, si static ca sa fie instantiat doar odata
   protected static $db;
   //creem alta variabila protected care o sa o folosim pentru sanitzare si il facem un array pentru a putea fi iterat
protected static $columnasDB=["id","titulo","precio","imagen","descripcion","habitaciones","wc","estacionamiento","creado","vendedores_id"];

//Errors
protected static $errores=[];



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

        //Definim conexiunea la baza de date 
     //utilizand variabile statice trebuie sa fie si functia statica ,plus  trebuie sa folosim self::
     //functia setDb o avem creata in app.php

     public static function setDB($database){
      self::$db= $database;
     }

     //si aici facem functia contruuctor pe care o vom utiliza pentru a acessa datele
     //punem args  care o sa fie un array
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
        $this ->vendedores_id = $args["vendedorId"]??'';
     }

     public function guardar(){


      //sanitizam datele ,si salvam in atributos ce avem la functia sanitazarAtributos
$atributos = $this->sanitzarAtributos();


//cu join facem din array un string, acesta ia doi parametri ,primu fiind separatoru si al doiea keyle care vrem sa le introducem


//iar aici adaugam datel deja sanitizate
//adaugand de forma automata atat keyurile cat si value cu functiile respective
      $query = "INSERT INTO propriedades ( ";
      $query .= join(', ',array_keys($atributos)) ;
      $query .= " ) VALUES (' ";
      $query .= join("', '",array_values($atributos));
      $query .= " ') ";

//iar asa introducem datele in baza de date
$resultado=self::$db->query($query);

return $resultado;
     }

     //functai aste o sa itereze fiecare atribut si sa il adauge la columna atributos
     public function atributos (){
$atributos=[];

foreach(self::$columnasDB as $columna){
   //spunem sa treaca peste atributo id cand itereaza
   if ($columna==="id"){
      continue;
   }
   //si aici salvam in atribute fiicare columna facand referinta cu this la fiecare atribut din columna
$atributos[$columna]= $this->$columna;

}
return $atributos;
     }

  public function sanitzarAtributos(){
//aici salvam din nou ce avem in functia atributos in variabila atributos
$atributos=$this->atributos();

$sanitzando = [];

//aici facem iar o iterare si vrem sa salvam atat keyu cat si valoarea
foreach($atributos as $key => $value){
//si asa facem sa salvam si key fiecare pozitie ex(titlu pre etc) ,iar dupa acesam baza de date si ii trimitem datele sanitizate
   $sanitzando[$key]= self::$db->escape_string($value);
}
return $sanitzando;
}
//Urcare de archive , in cazul nostru imaginea
public function setImagen($imagen){
   //si aici spunem daca avem o imagine trimisa prin parametru sa o salvam in variabila nostra  imagen din clasa

if ($imagen ){

   $this->imagen = $imagen;
}
}

//Validare

public static function getErrores(){

   return self::$errores;
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
      self::$errores[]="Trebuie introdusa o imagine";
      }
      return self::$errores;
}
}
?>