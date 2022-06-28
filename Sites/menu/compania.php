<?php
    session_start();
    $compania = $_SESSION["user"];
    if (is_null($compania)) {
        header("Location: ../index.php");
        exit();
    }

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

    $querycompania = "SELECT companiaaerea.nombre
                      FROM companiaaerea
                      WHERE companiaaerea.codigoca = '$compania';";
    $result_c = $db1 -> prepare($querycompania);
    $result_c -> execute();
    $nombre_compania = $result_c -> fetch();

    include('../templates/header.html');
    echo "<h1 class='title'>Vuelos de $nombre_compania[0]</h1>";
?>

<div>
    <h3>Vuelos aprobados</h3>
    <table class="table is-bordered is-hoverable is-fullwidth">
        <thead class="has-background-grey-dark">
        <tr>
            <th scope="col" class="has-text-white">Codigo Vuelo</th>
            <th scope="col" class="has-text-white">Fecha Salida</th>
            <th scope="col" class="has-text-white">Fecha Llegada</th>
            <th scope="col" class="has-text-white">Velocidad</th>
            <th scope="col" class="has-text-white">Altitud</th>
            <th scope="col" class="has-text-white">Id Aeronave</th>
            <th scope="col" class="has-text-white">Codigo ICAO Aerodromo Salida</th>
            <th scope="col" class="has-text-white">Codigo ICAO Aerodromo Llegada</th>
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
<div>
    <h3>Vuelos rechazados</h3>
    <table class="table is-bordered is-hoverable is-fullwidth">
        <thead class="has-background-grey-dark">
            <tr>
                <th scope="col" class="has-text-white">Codigo Vuelo</th>
                <th scope="col" class="has-text-white">Fecha Salida</th>
                <th scope="col" class="has-text-white">Fecha Llegada</th>
                <th scope="col" class="has-text-white">Velocidad</th>
                <th scope="col" class="has-text-white">Altitud</th>
                <th scope="col" class="has-text-white">Id Aeronave</th>
                <th scope="col" class="has-text-white">Codigo ICAO Aerodromo Salida</th>
                <th scope="col" class="has-text-white">Codigo ICAO Aerodromo Llegada</th>
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