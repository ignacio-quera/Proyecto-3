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


    // query filtro pasajes

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

    // query sin filtrar
    $query_sin_filtrar ="SELECT companiaaerea.nombre, origenes.ciudad, destinos.ciudad, vuelos.fechasalida, vuelos.fechallegada, tickets_pasajero.id
                        FROM vuelos, companiaaerea, ticket,
                        (SELECT aerodromo.codigoicao as orig, aerodromo.ciudad as ciudad
                        FROM aerodromo) as origenes,
                        (SELECT aerodromo.codigoicao as dest, aerodromo.ciudad as ciudad
                        FROM aerodromo) as destinos,
                        (SELECT reserva.idticket as id
                        FROM reserva
                        WHERE reserva.npasaportereservador like '%$pasaporte%') as tickets_pasajero
                        WHERE vuelos.salidaicao LIKE origenes.orig
                        AND vuelos.llegadaicao LIKE destinos.dest
                        AND vuelos.idvuelo LIKE ticket.idvuelo
                        AND tickets_pasajero.id LIKE ticket.idticket
                        AND companiaaerea.codigoca = vuelos.codigoca
                        ORDER BY vuelos.idvuelo ASC;";

    $sin_filtro= $db2 -> prepare($query_sin_filtrar);
    $sin_filtro -> execute();
    $reservas_sin_filtro = $sin_filtro -> fetchAll();

    // resultados
    if (!isset($_GET['origen']) || !isset($_GET['destino']) || !isset($_GET['fecha'])) {
        $_GET['origen'] = '';
        $_GET['destino'] = '';
        $_GET['fecha'] = '';
    }

    if ($_GET['origen'] != '' && $_GET['destino'] != '' && $_GET['fecha'] != '') {
        $origen = $_GET['origen'];
        $destino = $_GET['destino'];
        $fecha = $_GET['fecha'];

        $query_vuelos = "SELECT companiaaerea.nombre, origenes.ciudad, destinos.ciudad, vuelos.fechasalida, vuelos.fechallegada, tickets_pasajero.id
                         FROM vuelos, companiaaerea, ticket,
                         (SELECT aerodromo.codigoicao as orig, aerodromo.ciudad as ciudad
                          FROM aerodromo
                          WHERE aerodromo.ciudad LIKE '%$origen%') as origenes,
                         (SELECT aerodromo.codigoicao as dest, aerodromo.ciudad as ciudad
                          FROM aerodromo
                          WHERE aerodromo.ciudad LIKE '%$destino%') as destinos,
                         (SELECT reserva.idticket as id
                          FROM reserva
                          WHERE reserva.npasaportereservador like '%$pasaporte%') as tickets_pasajero
                         WHERE vuelos.salidaicao LIKE origenes.orig
                         AND vuelos.llegadaicao LIKE destinos.dest
                         AND vuelos.idvuelo LIKE ticket.idvuelo
                         AND tickets_pasajero.id LIKE ticket.idticket
                         AND companiaaerea.codigoca = vuelos.codigoca
                         ORDER BY vuelos.idvuelo ASC;";


    $resultados = $db1 -> prepare($query_vuelos);
    $resultados -> execute();
    $vuelos = $resultados -> fetchAll();
    } else {
        $vuelos = $reservas_sin_filtro;
    }

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

<h1 align="center">Aquí Puedes Filtrar Tus Vuelos</h1>
    <br>
    
    <form action="" method="GET">
        <div style="text-align:center">
            <label for="origen">Ciudad de Origen:</label>
            <select name="origen" id="origen">
                <?php
                    foreach($origen_vuelos as $datos){
                        echo "<option> $datos[0]</opcion>";
                    }
                ?>
            </select>
    
            <label for="destino">Ciudad de Destino:</label>
            <select name="destino" id="destino">
                <?php
                    foreach($destino_vuelos as $datos){
                        echo "<option> $datos[0]</opcion>";
                    }
                ?>
            </select>
    
            <input type="submit" value="Buscar"/>
        </div>
    </form>

    <br>
    
    <div style="margin-right:50px; margin-left:50px;" >
        <table align="center" class="table table-bordered" margin:4px style="width:100%">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Compañía Aérea</th>
                    <th scope="col">Origen</th>
                    <th scope="col">Destino</th>
                    <th scope="col">Fecha Salida</th>
                    <th scope="col">Fecha Llegada</th>
                    <th scope="col">ID Del Ticket</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if (!is_null($vuelos)) {
                        foreach($vuelos as $datos){
                            echo "<tr>
                                    <td>$datos[0]</td>
                                    <td>$datos[1]</td>
                                    <td>$datos[2]</td>
                                    <td>$datos[3]</td>
                                    <td>$datos[4]</td>
                                </tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
    
    <br>

<form action="busqueda_vuelos.php" method="GET">
    <div style="text-align:center">
        <button>Buscar Más Vuelos</button>
    </div>
</form>
</body>
</html>

