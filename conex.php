<?php
$servername = "localhost"; //!tambien sirve ip
$username = "root";
$password = "";
$database = "bbdd_barcos";

// Crear una conexión
$conn = mysqli_connect($servername, $username, $password, $database) or die("No se ha podido conectar al servidor de la bbdd, activa xampp");

$bd = mysqli_select_db($conn, $database) or die("no se puede conectar a la base de datos");

/*echo "Conexión exitosa a la base de datos <br/>";*/