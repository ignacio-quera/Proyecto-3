<?php
    session_start();
    $admin = $_SESSION["user"];
    if (is_null($admin)) {
        header("Location: https://codd.ing.puc.cl/~grupo57/index.php?");
        exit();
    }
    include('../templates/header.html');

    require("../config/conexion.php");

    if (!isset($_GET['fecha_1']) || !isset($_GET['fecha_2'])) {
        $_GET['fecha_1'] = '';
        $_GET['fecha_2'] = '';
    }

    if ($_GET['fecha_1'] != '' && $_GET['fecha_2'] != '') {
        $fecha_1 = $_GET['fecha_1'];
        $fecha_2 = $_GET['fecha_2'];
        $query = "SELECT vuelos.codigovuelo, vuelos.codigoca, vuelos.fechasalida, vuelos.fechallegada,
                  vuelos.velocidad, vuelos.altitud, vuelos.idruta, vuelos.idnave, vuelos.salidaicao,
                  vuelos.llegadaicao
                  FROM vuelos
                  WHERE vuelos.estado = 'pendiente'
                  AND vuelos.fechasalida >= '$fecha_1' AND vuelos.fechasalida <= '$fecha_2'
                  UNION
                  SELECT vuelos.codigovuelo, vuelos.codigoca, vuelos.fechasalida, vuelos.fechallegada,
                  vuelos.velocidad, vuelos.altitud, vuelos.idruta, vuelos.idnave, vuelos.salidaicao,
                  vuelos.llegadaicao
                  FROM vuelos
                  WHERE vuelos.estado = 'pendiente'
                  AND vuelos.fechallegada >= '$fecha_1' AND vuelos.fechallegada <= '$fecha_2'
                  UNION
                  SELECT vuelos.codigovuelo, vuelos.codigoca, vuelos.fechasalida, vuelos.fechallegada,
                  vuelos.velocidad, vuelos.altitud, vuelos.idruta, vuelos.idnave, vuelos.salidaicao,
                  vuelos.llegadaicao
                  FROM vuelos
                  WHERE vuelos.estado = 'pendiente'
                  AND vuelos.fechasalida <= '$fecha_1' AND vuelos.fechallegada >= '$fecha_2';";
        $result = $db1 -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
    } else {
        $query = "SELECT vuelos.codigovuelo, vuelos.codigoca, vuelos.fechasalida, vuelos.fechallegada,
                vuelos.velocidad, vuelos.altitud, vuelos.idruta, vuelos.idnave, vuelos.salidaicao,
                vuelos.llegadaicao
                FROM vuelos
                WHERE vuelos.estado = 'pendiente';";
        $result = $db1 -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
    }
?>

<h1>ADMIN</h1>

<div style="margin-right:50px; margin-left:50px;" class="container-fluid">
    <form action="" method="GET" class="form-inline">
        <div class="form-group">
            <label for="fecha_1">Fecha Inicial</label>
            <input type="date" name="fecha_1" id="fecha_1" class="form-control">
        </div>
        <div class="form-group">
            <label for="fecha_2">Fecha Final</label>
            <input type="date" name="fecha_2" id="fecha_2" class="form-control">
        </div>
        <button class="btn btn-info">Buscar Vuelos</button>
    </form>
</div>

<div style="margin-right:50px; margin-left:50px;" >
    <table align="center" class="table table-bordered" margin:4px style="width:100%">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Codigo Vuelo</th>
                <th scope="col">Codigo Compañia</th>
                <th scope="col">Fecha Salida</th>
                <th scope="col">Fecha Llegada</th>
                <th scope="col">Velocidad</th>
                <th scope="col">Altitud</th>
                <th scope="col">Id Ruta</th>
                <th scope="col">Id Aeronave</th>
                <th scope="col">Codigo ICAO Aerodromo Salida</th>
                <th scope="col">Codigo ICAO Aerodromo Llegada</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php
            foreach($data as $vuelo){
                echo "<tr>
                        <td>$vuelo[0]</td>
                        <td>$vuelo[1]</td>
                        <td>$vuelo[2]</td>
                        <td>$vuelo[3]</td>
                        <td>$vuelo[4]</td>
                        <td>$vuelo[5]</td>
                        <td>$vuelo[6]</td>
                        <td>$vuelo[7]</td>
                        <td>$vuelo[8]</td>
                        <td>$vuelo[9]</td>
                        <td>
                            <form method='POST' action='../funciones/admin_vuelos.php'>
                                <input type='submit' name='aceptar' value='Aceptar'/>
                            </form>
                            <form method='POST' action='../funciones/admin_vuelos.php'>
                                <input type='submit' name='rechazar' value='Rechazar'/>
                            </form>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>