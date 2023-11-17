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



    public function __construct($args =[])
    {
       //si asa adaugam datele in constrcutor, si in caz ca nu avem date poate fi un string gol
       //cand aveam functi publice folosim this
       $this -> id = $$args["id"]??'';
       $this-> nombre = $args["nombre"]??'';
       $this-> apellido = $args["apellido"]??'';
       $this-> telefono = $args["telefono"]??'';

       
      
    }
 
    public function validar()
    {
        if (!$this->nombre){
            self::$errores[]="Trebuie sa adaugi un nume";
        }
        if(!$this->apellido){
            self::$errores[]="Trebuie sa adaugi un prenume";

        }
        if(!$this->telefono){
            self::$errores[]="Trebuie sa adaugi un telefon";
        }
        //folosim preg_match pentru a ne asigura utilizeaza un tip de patron
//adica gen un email trebuie sa aiba @ si .com
    if(!preg_match('/[0-9]{10}/',$this->telefono)){
        self::$errores[]="Telefon invalid";
    }

        return self::$errores;
    }

  
}


?>