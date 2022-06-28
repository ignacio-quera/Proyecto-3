<?php
    session_start();
    $pasaporte = $_SESSION['user'];
    if (is_null($pasaporte)) {
        header("Location: ../index.php");
        exit();
    }

    require("../config/conexion.php");

    // query obtención datos pasajero
    $query = "SELECT pasajero.nombre, pasajero.npasaporte
              FROM pasajero
              WHERE pasajero.npasaporte like '%$pasaporte%';";
    $result = $db1 -> prepare($query);
    $result -> execute();
    $pasajero = $result -> fetch();

    // query pasajes

    // query origen
    $query_origenes = "SELECT DISTINCT ciudad.nombre_ciudad
                       FROM fpl
                       JOIN aerodromo ON fpl.aerodromo_salida_id = aerodromo.aerodromo_id
                       JOIN ciudad ON aerodromo.ciudad_id = ciudad.ciudad_id
                       WHERE fpl.estado LIKE '%aceptado%'
                       ORDER BY ciudad.nombre_ciudad ASC;";
    $result3 = $db2 -> prepare($query_origenes);
    $result3 -> execute();
    $origen_vuelos = $result3 -> fetchAll();

    // query destino
    $query_destinos = "SELECT DISTINCT ciudad.nombre_ciudad
                       FROM fpl
                       JOIN aerodromo ON fpl.aerodromo_llegada_id = aerodromo.aerodromo_id
                       JOIN ciudad ON aerodromo.ciudad_id = ciudad.ciudad_id
                       WHERE fpl.estado LIKE '%aceptado%'
                       ORDER BY ciudad.nombre_ciudad ASC;";
    $result4 = $db2 -> prepare($query_destinos);
    $result4 -> execute();
    $destino_vuelos = $result4 -> fetchAll();

    // resultados
    if (!isset($_GET['origen']) || !isset($_GET['destino'])) {
        $_GET['origen'] = '';
        $_GET['destino'] = '';
    }

    if ($_GET['origen'] != '' && $_GET['destino'] != '') {
        $origen = $_GET['origen'];
        $destino = $_GET['destino'];

        $query_vuelos = "SELECT companiaaerea.nombre, origenes.ciudad, destinos.ciudad, vuelos.fechasalida, vuelos.fechallegada, tickets_pasajero.id
                         FROM vuelos, companiaaerea, ticket,
                         (SELECT aerodromo.codigoicao as orig, aerodromo.ciudad as ciudad FROM aerodromo
                          WHERE aerodromo.ciudad LIKE '%$origen%') as origenes,
                         (SELECT aerodromo.codigoicao as dest, aerodromo.ciudad as ciudad FROM aerodromo
                          WHERE aerodromo.ciudad LIKE '%$destino%') as destinos,
                         (SELECT reserva.idticket as id FROM reserva
                          WHERE reserva.npasaportereservador like '%$pasaporte%') as tickets_pasajero
                         WHERE vuelos.salidaicao LIKE origenes.orig
                         AND vuelos.llegadaicao LIKE destinos.dest
                         AND vuelos.idvuelo = ticket.idvuelo
                         AND tickets_pasajero.id = ticket.idticket
                         AND companiaaerea.codigoca = vuelos.codigoca
                         ORDER BY vuelos.idvuelo ASC;";
    } else {
        $query_vuelos = "SELECT companiaaerea.nombre, origenes.ciudad, destinos.ciudad, vuelos.fechasalida, vuelos.fechallegada, tickets_pasajero.id
                         FROM vuelos, companiaaerea, ticket,
                         (SELECT aerodromo.codigoicao as orig, aerodromo.ciudad as ciudad FROM aerodromo) as origenes,
                         (SELECT aerodromo.codigoicao as dest, aerodromo.ciudad as ciudad FROM aerodromo) as destinos,
                         (SELECT reserva.idticket as id FROM reserva WHERE reserva.npasaportereservador like '%$pasaporte%') as tickets_pasajero
                         WHERE vuelos.salidaicao LIKE origenes.orig
                         AND vuelos.llegadaicao LIKE destinos.dest
                         AND vuelos.idvuelo = ticket.idvuelo
                         AND tickets_pasajero.id = ticket.idticket
                         AND companiaaerea.codigoca = vuelos.codigoca
                         ORDER BY vuelos.idvuelo ASC;";
    }
    $resultados = $db1 -> prepare($query_vuelos);
    $resultados -> execute();
    $vuelos = $resultados -> fetchAll();

    include('../templates/header.html');
?>

<h1 class="title is-2">¡Bienvenido Pasajero!</h1>

<div class="box">
    <h1 class='title is-4'>Informacion</h1>
    <div class="columns">
        <div class="column is-one-quarter"><strong>Nombre Completo:</strong></div>
        <div class="column"><?php echo "$pasajero[0]"?></div>
    </div>
    <div class="columns">
        <div class="column is-one-quarter"><strong>Número de Pasaporte:</strong></div>
        <div class="column"><?php echo "$pasajero[1]"?></div>
    </div>
</div>

<h1 class="title is-3">Tus Reservas</h1>

<div class="level box">
    <div class="level-left">
        <div class='level-item'>
            <h1 class="title is-black is-4">Filtrar</h1>
        </div>
    </div>
    <form action="" method="GET">
        <div class="level-right">
            <label for="origen" class="level-item"><strong>Ciudad de Origen:</strong></label>
            <select name="origen" id="origen" class="level-item select">
                <?php
                    foreach($origen_vuelos as $datos){
                        echo "<option> $datos[0]</opcion>";
                    }
                ?>
            </select>

            <label for="destino" class="level-item"><strong>Ciudad de Destino:</strong></label>
            <select name="destino" id="destino" class="level-item select">
                <?php
                    foreach($destino_vuelos as $datos){
                        echo "<option> $datos[0]</opcion>";
                    }
                ?>
            </select>

            <input type="submit" value="Buscar" class="button is-info level-item"/>
        </form>
        
        <form action="" method="GET">
            <input type="submit" value="Resetear Filtro" class="button is-light level-item"/>
        </div>
    </form>
</div>

<div>
    <table class="table is-bordered is-fullwidth">
        <thead class="has-background-grey-dark">
            <tr>
                <th scope="col" class="has-text-white">Compañía Aérea</th>
                <th scope="col" class="has-text-white">Origen</th>
                <th scope="col" class="has-text-white">Destino</th>
                <th scope="col" class="has-text-white">Fecha Salida</th>
                <th scope="col" class="has-text-white">Fecha Llegada</th>
                <th scope="col" class="has-text-white">ID Del Ticket</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($vuelos as $datos){
                    echo "<tr>
                            <td>$datos[0]</td>
                            <td>$datos[1]</td>
                            <td>$datos[2]</td>
                            <td>$datos[3]</td>
                            <td>$datos[4]</td>
                            <td>$datos[5]</td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>
</div>

<br>

<form action="busqueda_vuelos.php">
    <div style="text-align:center">
        <button class="button is-info">Buscar Más Vuelos</button>
    </div>
</form>
</div>
</body>
</html>
