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
        $this ->vendedores_id =1;
      //   $args["vendedorId"]??
     }

     public function guardar(){
      //cu ifu asta sepcificam daca exista id actualizam altfel creem
      if (($this->id)!="") {
         //Actualizar
         $this->actualizar();
      } else{
         //Creando un nuevo registro
         $this->crear();
      }

     }

public function crear(){


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


//Mesaj de succes sau fail
if($resultado){
   //Daca totu este ok facem un redirect iar dupa ce punem ? putem trimite date care
   //pot fi citite in locatia unde facem redirect ,iar cu & putem adauga mai multe mesajr
   header('Location: /admin?resultado=1');
}     }

     public function actualizar(){
      $atributos = $this->sanitzarAtributos();

      //dupa ce am sanitizat creem arrayu pentru a uni valorile cu atributele

      $valores=[];
      //si aici cu foreach trecem peste toate atributele si le adaugam la proprietati de forma automata
      //actualizandule
      foreach($atributos as $key =>$value){
         $valores[]="{$key}='{$value}'";
      }
//trebuie lasat mereu un spatiu dupa set inainte de "
   $query =   "UPDATE propriedades SET " ;
    $query .= join(', ', $valores);
//si asa spunem sa ne schimbe unde este id pe care il primim si in acelasi timp il sanitizam
   $query .=" WHERE id= '" . self::$db->escape_string( $this->id) . "' ";

   //ii mai punem si un limit
   $query .= " LIMIT 1";

   $resultado= self::$db->query($query);

   
   
   if($resultado){
      //Daca totu este ok facem un redirect iar dupa ce punem ? putem trimite date care
      //pot fi citite in locatia unde facem redirect ,iar cu & putem adauga mai multe mesajr
      header('Location: /admin?resultado=2');
  }
   }
        

   //functia asta o folosim sa stergem o prorietate dupa id

   public function eliminar (){
      $query = "DELETE  from propriedades WHERE id = ".self::$db->escape_string($this->id) . " LIMIT 1";
      $resultado = self::$db->query($query);

      $this->borrarImagen();
         if($resultado){
            //facem un redirect si in acelasi timp setam resultadu la 3 pe care o sa il utilizam
            //sa comprobam daca este 3 sa ne apara mesaju ca proprietatea a fost stearsa
            header("Location : /admin?resultado=3");
        }
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
//Elimina imaginea anterioARE
if(isset($this->id)){
   //pentru a reutiliza codul putem folosi direct functia borar (pt ca are acelasi cod )
 $this->borrarImagen();
}
   //si aici spunem daca avem o imagine trimisa prin parametru sa o salvam in variabila nostra  imagen din clasa

if ($imagen ){

   $this->imagen = $imagen;
}

}


//functia pentru a sterge imaginea
public function borrarImagen(){
   //Comprobam daca exista archivo, si daca exista il elimnam cu ulink pentru al actualiza

   $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
   if($existeArchivo){
unlink(CARPETA_IMAGENES . $this->imagen);
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

//Listeaza toate proprietatilie
//facem o functie dinamica care poate primi diferite consulte

//si functile care urmeaza fac urmatoarele (transforma dintru array intrun obiect ,pentru ca asa functioneaza active record)
public static function all (){
 
$query ="SELECT  * FROM propriedades";

 $resultado =self::consultarSQL($query);

 return $resultado;


}

//Cauta o proprietate in functie de id
public static function find($id){
   //Consultam sa vedem ce vanzatori avem , si utilizam aceaeasi functi consultarSql pentru a transforma rezultatu in obiect

$query = "SELECT * FROM  propriedades where id ={$id}" ;

$resultado =self::consultarSQL($query);
//cu array shift spunem ca vrem sa ne arate doar prima pozitie a arraiului
return array_shift($resultado);
}



public static function consultarSQL($query){

   //Consultam baza de date
$resultado = self::$db->query($query);

   //Iteram rezultatele
$array=[];

while ($registro = $resultado->fetch_assoc()){
   
   $array[]=self::crearObjeto($registro);
}

   //Eliberam memoria

$resultado->free();
   //returnam rezultatul

   return $array;

}

protected static function crearObjeto ($registro){

   $objeto = new self;


   foreach($registro as $key =>$value){

      if(property_exists($objeto,$key)){
         $objeto->$key=$value;
      }
   }

   return $objeto;
}



//sincronizeaza schimbarile din memorie cu cea ce adauga userul (se utilizeaza pentru actualizare)
//o sa primeasca ca parametru un array gol
public function sincronizar($args =[]){

   //iar cu foreach actualizam datele , si dupa folsoim if sa vedem daca exista proprietate
   //referindune la cea deja salvata in memorie adica in constructor, si in caz ca se actualizeaza
   //adica o sa primim prin arrayul din argument noi date o sa le schimbam pe cele vechi
   //iar daca este null sa ii trecem valoare care exista deja
   foreach($args as $key =>$value){
      if(property_exists($this, $key)&& !is_null($value)){
         $this->$key = $value;
      }
   }
}
}
?>