<?php 


require "includes/app.php";


$db =conectarDB();


//Creear email and password

$email = "correo@correo.com";
$password = "123456";

$passwordHash = password_hash($password, PASSWORD_BCRYPT);
//Query pentru a crea userul

 $query="INSERT INTO usuarios  (email,password) 
 VALUES ('$email', '$passwordHash')";

//Adaugam userul

mysqli_query($db ,$query);
?>