<?php
    session_start();
    $compania = $_SESSION["user"];
    if (is_null($compania)) {
        header("Location: https://codd.ing.puc.cl/~grupo57/index.php?");
        exit();
    }
    include('../templates/header.html');

    require("../config/conexion.php");

    $query = "SELECT vuelos.codigovuelo, vuelos.fechasalida, vuelos.fechallegada,
              vuelos.velocidad, vuelos.altitud, vuelos.idnave, vuelos.salidaicao,
              vuelos.llegadaicao
              FROM vuelos
              WHERE vuelos.codigoca = '$compania' AND vuelos.estado = 'aceptado';";
    $result = $db1 -> prepare($query);
    $result -> execute();
    $ca_aprobado = $result -> fetchAll();

    $query_2 = "SELECT vuelos.codigovuelo, vuelos.fechasalida, vuelos.fechallegada,
                vuelos.velocidad, vuelos.altitud, vuelos.idnave, vuelos.salidaicao,
                vuelos.llegadaicao
                FROM vuelos
                WHERE vuelos.codigoca = '$compania' AND vuelos.estado = 'rechazado';";
    $result_2 = $db1 -> prepare($query_2);
    $result_2 -> execute();
    $ca_rechazado = $result_2 -> fetchAll();

    echo "<h1>Vuelos de $compania</h1>";
?>

<div style="margin-right:50px; margin-left:50px;" >
    <h3>Vuelos aprobados</h3>
    <table align="center" class="table table-bordered" margin:4px style="width:100%">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Codigo Vuelo</th>
            <th scope="col">Fecha Salida</th>
            <th scope="col">Fecha Llegada</th>
            <th scope="col">Velocidad</th>
            <th scope="col">Altitud</th>
            <th scope="col">Id Aeronave</th>
            <th scope="col">Codigo ICAO Aerodromo Salida</th>
            <th scope="col">Codigo ICAO Aerodromo Llegada</th>
        </tr>
        </thead>
        <tbody>
            <?php
            foreach($ca_aprobado as $vuelo){
                echo "<tr>
                        <td>$vuelo[0]</td>
                        <td>$vuelo[1]</td>
                        <td>$vuelo[2]</td>
                        <td>$vuelo[3]</td>
                        <td>$vuelo[4]</td>
                        <td>$vuelo[5]</td>
                        <td>$vuelo[6]</td>
                        <td>$vuelo[7]</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<div style="margin-right:50px; margin-left:50px;" >
    <h3>Vuelos rechazados</h3>
    <table align="center" class="table table-bordered" margin:4px style="width:100%">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Codigo Vuelo</th>
                <th scope="col">Fecha Salida</th>
                <th scope="col">Fecha Llegada</th>
                <th scope="col">Velocidad</th>
                <th scope="col">Altitud</th>
                <th scope="col">Id Aeronave</th>
                <th scope="col">Codigo ICAO Aerodromo Salida</th>
                <th scope="col">Codigo ICAO Aerodromo Llegada</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($ca_rechazado as $vuelo){
                echo "<tr>
                        <td>$vuelo[0]</td>
                        <td>$vuelo[1]</td>
                        <td>$vuelo[2]</td>
                        <td>$vuelo[3]</td>
                        <td>$vuelo[4]</td>
                        <td>$vuelo[5]</td>
                        <td>$vuelo[6]</td>
                        <td>$vuelo[7]</td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>