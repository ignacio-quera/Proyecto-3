<?php
    session_start();
    $pasaporte = $_SESSION['user'];
    if (is_null($pasaporte)) {
        header("Location: https://codd.ing.puc.cl/~grupo57/index.php?");
        exit();
    }
    include('../templates/header.html');

    require("../config/conexion.php");

    // query obtención datos pasajero
    $query = "SELECT pasajero.nombre, pasajero.npasaporte
              FROM pasajero
              WHERE pasajero.npasaporte like '%$pasaporte%';";
              // Falta agregar las reservas

    $result = $db1 -> prepare($query);
    $result -> execute();
    $pasajero = $result -> fetchAll();

    // query obtención reservas pasajero
    $query2 = "SELECT reserva.idreserva, reserva.idticket
              FROM reserva
              WHERE reserva.npasaportereservador like '%$pasaporte%';";

    $result2 = $db1 -> prepare($query2); 
    $result2 -> execute();    
    $reservas = $result2 -> fetchAll();
?>

<h1 align="center">¡Bienvenido Pasajero!</h1>
<br>
<div style="margin-right:50px; margin-left:50px;" >
    <table align="center" class="table table-bordered" margin:4px style="width:100%">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Número de Pasaporte</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($pasajero as $datos){
                    echo "<tr><td>$datos[0]</td><td>$datos[1]</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>

<div style="margin-right:50px; margin-left:50px;" >
    <table align="center" class="table table-bordered" margin:4px style="width:100%">
        <thead class="thead-dark">
        <tr>
            <th scope="col">ID de la Reserva</th>
            <th scope="col">ID del Ticket Asociado</th>
        </tr>
        </thead>
        <tbody>
            <?php
                foreach($reservas as $datos){
                    echo "<tr><td>$datos[0]</td><td>$datos[1]</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>

<form action="busqueda_vuelos.php" method="GET">
    <div style="text-align:center">
        <button>Buscar Vuelos</button>
    </div>
</form>
</body>
</html>