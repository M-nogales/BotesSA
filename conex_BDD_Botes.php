<?php
include_once('conex.php');
/*
* Nombre del barco, desplazamiento y cantidad de cañones, de los barcos que participaron en la batalla de Guadalcanal.
* batalla guadalcanal no existe, existe del pacífico*/
$consult1 = "SELECT B.NOMBRE_BARCO, C.DESPLAZAMIENTO, C.NRO_CANIONES
FROM BARCO_CLASE BC
LEFT JOIN BARCOS B ON BC.NOMBRE_BARCO = B.NOMBRE_BARCO
LEFT JOIN CLASES C ON BC.CLASE = C.CLASE
LEFT JOIN RESULTADOS R ON B.NOMBRE_BARCO = R.NOMBRE_BARCO
LEFT JOIN BATALLAS BA ON R.NOMBRE_BATALLA = BA.NOMBRE_BATALLA
WHERE BA.NOMBRE_BATALLA = 'Guadalcanal';";
/*
* Encontrar aquellos países que dispongan tanto de acorazados como
* de cruceros. */
$consult2 = "SELECT PAIS
FROM CLASES
WHERE TIPO IN ('ACORAZADO', 'CRUCERO')
GROUP BY PAIS
HAVING COUNT(DISTINCT TIPO) = 2;";/*agrupa los paises que tengan tipos Acorazado o crucero 
y que además tengan dos tipos distintos, es decir, que tengan ambos*/

/*
 * Encontrar aquellas batallas en las cuales un mismo país participo con
 * al menos tres barcos.
 */
$consult3 = "SELECT R.NOMBRE_BATALLA, C.PAIS
FROM RESULTADOS R
LEFT JOIN BATALLAS B ON R.NOMBRE_BATALLA = B.NOMBRE_BATALLA
LEFT JOIN BARCO_CLASE BC ON R.NOMBRE_BARCO = BC.NOMBRE_BARCO
LEFT JOIN CLASES C ON BC.CLASE = C.CLASE
GROUP BY R.NOMBRE_BATALLA, C.PAIS
HAVING COUNT(R.NOMBRE_BARCO) >= 3;";

/*
* Encontrar los países cuyos barcos tengan el mayor número de
* cañones.*/
$consult4 = "SELECT PAIS, NRO_CANIONES
FROM CLASES
WHERE NRO_CANIONES = (SELECT MAX(NRO_CANIONES) FROM CLASES);";/* NO ENCUENTRO FORMA SIN SUBCONSULTA */

/*
* Encontrar las batallas en las cuales participaron barcos de la clase
* kongo. */
$consult5 = "SELECT R.NOMBRE_BATALLA
FROM RESULTADOS R
LEFT JOIN BARCOS B ON R.NOMBRE_BARCO = B.NOMBRE_BARCO
LEFT JOIN CLASES C ON B.NOMBRE_BARCO = C.CLASE
WHERE C.CLASE = 'KONGO'";

$resultado1 = mysqli_query($conn, $consult1) or die("Has hecho una mala consulta a la bbdd");
$resultado2 = mysqli_query($conn, $consult2) or die("Has hecho una mala consulta a la bbdd");
$resultado3 = mysqli_query($conn, $consult3) or die("Has hecho una mala consulta a la bbdd");
$resultado4 = mysqli_query($conn, $consult4) or die("Has hecho una mala consulta a la bbdd");
$resultado5 = mysqli_query($conn, $consult5) or die("Has hecho una mala consulta a la bbdd");

// Motrar el resultado de los registro de la base de datos
// Encabezado de la tabla
//! mostrar primera consulta
$resultado_conex1 = "<table class=\"table table-bordered table-striped table-hover Main-table-border mb-0\">";
$resultado_conex1 .= "<tr class='Main-Orange'>";

// nombres de las columnas
while ($columna = mysqli_fetch_field($resultado1)) {
  $resultado_conex1 .= "<th scope=" . "col" . ">{$columna->name}</th>";
}
if (mysqli_num_rows($resultado1) > 0) {
  // Bucle while que recorre cada registro y muestra cada campo en la tabla.
  while ($fila = mysqli_fetch_assoc($resultado1)) {
    $resultado_conex1 .= "<tr>";
    foreach ($fila as $value) {
      $resultado_conex1 .= "<td  scope=" . "row" . ">$value</td>";
    }
    $resultado_conex1 .= "</tr>";
  }
} else {
  // en caso de no encontrar resultados en la consulta dejamos una fila con lo siguiente
  $resultado_conex1 .= "<tr><td colspan='" . mysqli_num_fields($resultado1) . "'>No se encontraron resultados</td></tr>";
}
$resultado_conex1 .= "</table>";
/*echo $resultado_conex1;*/

//! mostrar segunda consulta
$resultado_conex2 = "<table class=\"table table-bordered table-striped table-hover Main-table-border mb-0\">";
$resultado_conex2 .= "<tr class='Main-Orange'>";

// nombres de las columnas
while ($columna = mysqli_fetch_field($resultado2)) {
  $resultado_conex2 .= "<th scope=" . "col Main-Orange" . ">{$columna->name}</th>";
}
if (mysqli_num_rows($resultado2) > 0) {
  // Bucle while que recorre cada registro y muestra cada campo en la tabla.
  while ($fila = mysqli_fetch_assoc($resultado2)) {
    $resultado_conex2 .= "<tr>";
    foreach ($fila as $value) {
      $resultado_conex2 .= "<td  scope=" . "row" . ">$value</td>";
    }
    $resultado_conex2 .= "</tr>";
  }
} else {
  // en caso de no encontrar resultados en la consulta dejamos una fila con lo siguiente
  $resultado_conex2 .= "<tr><td colspan='" . mysqli_num_fields($resultado2) . "'>No se encontraron resultados</td></tr>";
}
$resultado_conex2 .= "</table>";
/*echo $resultado_conex2;*/
//! mostrar tercera consulta
$resultado_conex3 = "<table class=\"table table-bordered table-striped table-hover Main-table-border mb-0\">";
$resultado_conex3 .= "<tr class='Main-Orange'>";

// nombres de las columnas
while ($columna = mysqli_fetch_field($resultado3)) {
  $resultado_conex3 .= "<th scope=" . "col" . ">{$columna->name}</th>";
}
if (mysqli_num_rows($resultado3) > 0) {
  // Bucle while que recorre cada registro y muestra cada campo en la tabla.
  while ($fila = mysqli_fetch_assoc($resultado3)) {
    $resultado_conex3 .= "<tr>";
    foreach ($fila as $value) {
      $resultado_conex3 .= "<td  scope=" . "row" . ">$value</td>";
    }
    $resultado_conex3 .= "</tr>";
  }
} else {
  // en caso de no encontrar resultados en la consulta dejamos una fila con lo siguiente
  $resultado_conex3 .= "<tr><td colspan='" . mysqli_num_fields($resultado3) . "'>No se encontraron resultados</td></tr>";
}
$resultado_conex3 .= "</table>";
/*echo $resultado_conex3;*/
//! mostrar cuarta consulta
$resultado_conex4 = "<table class=\"table table-bordered table-striped table-hover Main-table-border mb-0\">";
$resultado_conex4 .= "<tr class='Main-Orange'>";

// nombres de las columnas
while ($columna = mysqli_fetch_field($resultado4)) {
  $resultado_conex4 .= "<th scope=" . "col" . ">{$columna->name}</th>";
}
if (mysqli_num_rows($resultado4) > 0) {
  // Bucle while que recorre cada registro y muestra cada campo en la tabla.
  while ($fila = mysqli_fetch_assoc($resultado4)) {
    $resultado_conex4 .= "<tr>";
    foreach ($fila as $value) {
      $resultado_conex4 .= "<td  scope=" . "row" . ">$value</td>";
    }
    $resultado_conex4 .= "</tr>";
  }
} else {
  // en caso de no encontrar resultados en la consulta dejamos una fila con lo siguiente
  $resultado_conex4 .= "<tr><td colspan='" . mysqli_num_fields($resultado4) . "'>No se encontraron resultados</td></tr>";
}
$resultado_conex4 .= "</table>";
/*echo $resultado_conex4;*/
//! mostrar quinta consulta
$resultado_conex5 = "<table class=\"table table-bordered table-striped table-hover Main-table-border mb-0\">";
$resultado_conex5 .= "<tr class='Main-Orange'>";

// nombres de las columnas
while ($columna = mysqli_fetch_field($resultado5)) {
  $resultado_conex5 .= "<th scope=" . "col" . ">{$columna->name}</th>";
}
if (mysqli_num_rows($resultado5) > 0) {
  // Bucle while que recorre cada registro y muestra cada campo en la tabla.
  while ($fila = mysqli_fetch_assoc($resultado5)) {
    $resultado_conex5 .= "<tr>";
    foreach ($fila as $value) {
      $resultado_conex5 .= "<td  scope=" . "row" . ">$value</td>";
    }
    $resultado_conex5 .= "</tr>";
  }
} else {
  // en caso de no encontrar resultados en la consulta dejamos una fila con lo siguiente
  $resultado_conex5 .= "<tr><td colspan='" . mysqli_num_fields($resultado5) . "'>No se encontraron resultados</td></tr>";
}
$resultado_conex5 .= "</table>";
/*echo $resultado_conex5;*/
$conn->close();
