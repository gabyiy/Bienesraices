<?php 

require "includes/app.php";


$db = conectarDB();

//arrayul de erori mereu se aseaza de forma globala
$errores = [];
//autetificar user


//asa spunem doar cand avem un post sa faca urmatori pasi

if($_SERVER["REQUEST_METHOD"]==="POST"){
//folosim echo pre ca sa se vada mai bine ,dar putem folosi doar var_dump
//     echo "<pre>";
// var_dump($_POST);
// echo "</pre>";

//cu mysql facem datele mai sigure si folosim filter ca sa confirmam ca este un mail
$email = mysqli_real_escape_string($db, filter_var( $_POST['email'],FILTER_VALIDATE_EMAIL));


$password =mysqli_real_escape_string($db ,$_POST['password']);

if(!$email){
  $errores[]= "Please enter a email, or write an  valid email";  
}

if(!$password){
    $errores[]="Please enter a password";
}

if (empty($errores)){

    //Revizam daca useru exista
$query ="SELECT * FROM usuarios WHERE email = '$email'";
$resultado = mysqli_query($db , $query);

//asa verificam daca exista vrun mail cu acelasi nume
    if($resultado ->num_rows){
        //Aici verificam daca passwordul este corect
        $usuario = mysqli_fetch_assoc($resultado);


        //Pentru a verifica parolo folosim pasword verify

        $auth = password_verify($password,$usuario['password']);

        if($auth){
                //paswordul userul este ok si salvam userul cu session
                //daca totu este ok se salveaza ca este logat
                //iar dupa in admin/index.php o sa avem acces sa vedem datele de acolo 
                //altfel un undex.php o sa ne redirectionez in alta parte
                session_start();

                $_SESSION['usuario']=$usuario['email'];
                $_SESSION['login']=true;


                
              header("Location: /admin");


        }else{
            $errores[]= "Passwordul nu este corect";
        }

    }else{

        $errores[]= "Emailu nu exista";
    }
}
}

$inicio = true;


//include header

incluirTemplate("header");

?>
<main class="contenedor seccion contenido-centrado">
<h3>Inicar session</h3>

<?php 
    foreach($errores as $error):?>
    
    <div class="alerta error"><?php  echo $error;?></div>
    <?php endforeach;?>
<form method="POST" >
<fieldset>
                <legend>Email and password</legend>

                <label for="email">E-mail</label>
                <!-- punem required cand vrem sa fie obligatoriu introducerea datelor in input -->
                <input type="email" placeholder="Tu Email" name="email" id="email" required>


                <label for="pasword">Mensaje:</label>
                <input type="number" id="password" name="password" placeholder="Entra tu password" required>
            </fieldset>
            <input type="submit" value="Enviar" class="boton boton-verde">

</form>


</main>


<?php 
incluirTemplate("footer");
?>