<?php
    session_start();
    $admin = $_SESSION["user"];
    if (is_null($admin)) {
        header("Location: ../index.php");
        exit();
    }

    require("../config/conexion.php");

    if (!isset($_GET['fecha_1']) || !isset($_GET['fecha_2'])) {
        $_GET['fecha_1'] = '';
        $_GET['fecha_2'] = '';
    }

    if ($_GET['fecha_1'] != '' && $_GET['fecha_2'] != '') {
        $fecha_1 = $_GET['fecha_1'];
        $fecha_2 = $_GET['fecha_2'];
        $query = "SELECT fpl.codigo, compania.nombre_compania, fpl.fecha_salida, fpl.fecha_llegada, fpl.codigo_aeronave,
                  aerodromo.nombre AS aero_salida, aerodromo2.nombre AS aero_llegada, fpl.propuesta_vuelo_id
                  FROM fpl, aerodromo, aerodromo AS aerodromo2, propuestavuelo, compania
                  WHERE fpl.estado = 'pendiente' AND fpl.tipo_vuelo = 'comercial'
                  AND fpl.aerodromo_salida_id = aerodromo.aerodromo_id
                  AND fpl.aerodromo_llegada_id = aerodromo2.aerodromo_id
                  AND fpl.propuesta_vuelo_id = propuestavuelo.propuesta_vuelo_id
                  AND propuestavuelo.codigo_compania = compania.codigo_compania
                  AND DATE(fpl.fecha_salida) >= '$fecha_1' AND DATE(fpl.fecha_salida) <= '$fecha_2'
                  UNION
                  SELECT fpl.codigo, compania.nombre_compania, fpl.fecha_salida, fpl.fecha_llegada, fpl.codigo_aeronave,
                  aerodromo.nombre AS aero_salida, aerodromo2.nombre AS aero_llegada, fpl.propuesta_vuelo_id
                  FROM fpl, aerodromo, aerodromo AS aerodromo2, propuestavuelo, compania
                  WHERE fpl.estado = 'pendiente' AND fpl.tipo_vuelo = 'comercial'
                  AND fpl.aerodromo_salida_id = aerodromo.aerodromo_id
                  AND fpl.aerodromo_llegada_id = aerodromo2.aerodromo_id
                  AND fpl.propuesta_vuelo_id = propuestavuelo.propuesta_vuelo_id
                  AND propuestavuelo.codigo_compania = compania.codigo_compania
                  AND DATE(fpl.fecha_llegada) >= '$fecha_1' AND DATE(fpl.fecha_llegada) <= '$fecha_2'
                  UNION
                  SELECT fpl.codigo, compania.nombre_compania, fpl.fecha_salida, fpl.fecha_llegada, fpl.codigo_aeronave,
                  aerodromo.nombre AS aero_salida, aerodromo2.nombre AS aero_llegada, fpl.propuesta_vuelo_id
                  FROM fpl, aerodromo, aerodromo AS aerodromo2, propuestavuelo, compania
                  WHERE fpl.estado = 'pendiente' AND fpl.tipo_vuelo = 'comercial'
                  AND fpl.aerodromo_salida_id = aerodromo.aerodromo_id
                  AND fpl.aerodromo_llegada_id = aerodromo2.aerodromo_id
                  AND fpl.propuesta_vuelo_id = propuestavuelo.propuesta_vuelo_id
                  AND propuestavuelo.codigo_compania = compania.codigo_compania
                  AND DATE(fpl.fecha_salida) <= '$fecha_1' AND DATE(fpl.fecha_llegada) >= '$fecha_2';";
        $result = $db2 -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
    } else {
        $query = "SELECT fpl.codigo, compania.nombre_compania, fpl.fecha_salida, fpl.fecha_llegada, fpl.codigo_aeronave,
                  aerodromo.nombre AS aero_salida, aerodromo2.nombre AS aero_llegada, fpl.propuesta_vuelo_id
                  FROM fpl, aerodromo, aerodromo AS aerodromo2, propuestavuelo, compania
                  WHERE fpl.estado = 'pendiente' AND fpl.tipo_vuelo = 'comercial'
                  AND fpl.aerodromo_salida_id = aerodromo.aerodromo_id
                  AND fpl.aerodromo_llegada_id = aerodromo2.aerodromo_id
                  AND fpl.propuesta_vuelo_id = propuestavuelo.propuesta_vuelo_id
                  AND propuestavuelo.codigo_compania = compania.codigo_compania;";
        $result = $db2 -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
    }

    include('../templates/header.html');
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
                <th scope="col">Compañia</th>
                <th scope="col">Fecha Salida</th>
                <th scope="col">Fecha Llegada</th>
                <th scope="col">Codigo Aeronave</th>
                <th scope="col">Aerodromo Salida</th>
                <th scope="col">Aerodromo Llegada</th>
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
                        <td>
                            <form method='POST' action='../funciones/admin_vuelos.php'>
                                <input type='hidden' name='id_vuelo' value='$vuelo[7]'>
                                <input type='submit' name='estado' value='aceptar'/>
                            </form>
                            <form method='POST' action='../funciones/admin_vuelos.php'>
                                <input type='hidden' name='id_vuelo' value='$vuelo[7]'>
                                <input type='submit' name='estado' value='rechazar'/>
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