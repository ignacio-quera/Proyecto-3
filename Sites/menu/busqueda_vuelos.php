<?php
    session_start();
    $pasaporte = $_SESSION['user'];
    if (is_null($pasaporte)) {
        header("Location: https://codd.ing.puc.cl/~grupo57/index.php?");
        exit();
    }
    include('../templates/header.html');

    require("../config/conexion.php");

    // query obtención de los origenes
    $query_origenes = "SELECT DISTINCT ciudad.nombre_ciudad
                       FROM fpl
                       JOIN aerodromo ON fpl.aerodromo_salida_id = aerodromo.aerodromo_id
                       JOIN ciudad ON aerodromo.ciudad_id = ciudad.ciudad_id
                       WHERE fpl.estado LIKE '%aceptado%'
                       ORDER BY ciudad.nombre_ciudad ASC;";

    $result = $db2 -> prepare($query_origenes);
    $result -> execute();
    $origen_vuelos = $result -> fetchAll();

    // query obtención de los destinos
    $query_destinos = "SELECT DISTINCT ciudad.nombre_ciudad
                       FROM fpl
                       JOIN aerodromo ON fpl.aerodromo_llegada_id = aerodromo.aerodromo_id
                       JOIN ciudad ON aerodromo.ciudad_id = ciudad.ciudad_id
                       WHERE fpl.estado LIKE '%aceptado%'
                       ORDER BY ciudad.nombre_ciudad ASC;";

    $result2 = $db2 -> prepare($query_destinos);
    $result2 -> execute();
    $destino_vuelos = $result2 -> fetchAll();

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

        $query_vuelos = "SELECT companiaaerea.nombre, vuelos.codigovuelo, origenes.ciudad, vuelos.fechasalida, destinos.ciudad, vuelos.fechallegada
                         FROM vuelos, companiaaerea, (SELECT aerodromo.codigoicao as orig, aerodromo.ciudad as ciudad
                                                      FROM aerodromo
                                                      WHERE aerodromo.ciudad LIKE '%$origen%') as origenes,
                         (SELECT aerodromo.codigoicao as dest, aerodromo.ciudad as ciudad
                          FROM aerodromo
                          WHERE aerodromo.ciudad LIKE '%$destino%') as destinos
                         WHERE vuelos.salidaicao LIKE origenes.orig
                         AND vuelos.llegadaicao LIKE destinos.dest
                         AND DATE(vuelos.fechasalida) = '$fecha'
                         AND vuelos.estado LIKE '%aceptado%'
                         AND companiaaerea.codigoca = vuelos.codigoca
                         ORDER BY vuelos.idvuelo ASC;";

    $resultados = $db1 -> prepare($query_vuelos);
    $resultados -> execute();
    $vuelos = $resultados -> fetchAll();
    } else {
        $vuelos = null;
    }
?>

<h1 align="center">¡Aquí Puedes Buscar Vuelos!</h1>
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

        <label for="fecha">Fecha de Despegue:</label>
        <input type="date" name="fecha" id="fecha"/>

        <input type="submit" value="Buscar"/>
    </div>
</form>

<h1 align="center">Estos Son Los Vuelos Disponibles Según Tu Búsqueda</h1>
<br>

<div style="margin-right:50px; margin-left:50px;" >
    <table align="center" class="table table-bordered" margin:4px style="width:100%">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Compañía</th>
                <th scope="col">Código de Vuelo</th>
                <th scope="col">Ciudad Despegue</th>
                <th scope="col">Fecha de Despegue</th>
                <th scope="col">Ciudad Arribo</th>
                <th scope="col">Fecha de Arribo</th>
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
                                <td>$datos[5]</td>
                                <td>
                                    <form method='GET' action='reservar.php'>
                                        <input type='submit' value='Reservar'/>
                                    </form>
                                </td>
                            </tr>";
                    }
                }
            ?>
        </tbody>
    </table>
</div>

<br>
<br>

<form align="center" action="pasajero.php" method="get">
    <input type="submit" value="Volver">
</form>
</body>
</html>