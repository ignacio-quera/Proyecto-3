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
                  aerodromo.nombre AS aero_salida, aerodromo2.nombre AS aero_llegada, fpl.propuesta_vuelo_id,
                  fpl.aerodromo_salida_id, fpl.aerodromo_llegada_id
                  FROM fpl, aerodromo, aerodromo AS aerodromo2, propuestavuelo, compania
                  WHERE fpl.estado = 'pendiente' AND fpl.tipo_vuelo = 'comercial'
                  AND fpl.aerodromo_salida_id = aerodromo.aerodromo_id
                  AND fpl.aerodromo_llegada_id = aerodromo2.aerodromo_id
                  AND fpl.propuesta_vuelo_id = propuestavuelo.propuesta_vuelo_id
                  AND propuestavuelo.codigo_compania = compania.codigo_compania
                  AND DATE(fpl.fecha_salida) >= '$fecha_1' AND DATE(fpl.fecha_salida) <= '$fecha_2'
                  UNION
                  SELECT fpl.codigo, compania.nombre_compania, fpl.fecha_salida, fpl.fecha_llegada, fpl.codigo_aeronave,
                  aerodromo.nombre AS aero_salida, aerodromo2.nombre AS aero_llegada, fpl.propuesta_vuelo_id,
                  fpl.aerodromo_salida_id, fpl.aerodromo_llegada_id
                  FROM fpl, aerodromo, aerodromo AS aerodromo2, propuestavuelo, compania
                  WHERE fpl.estado = 'pendiente' AND fpl.tipo_vuelo = 'comercial'
                  AND fpl.aerodromo_salida_id = aerodromo.aerodromo_id
                  AND fpl.aerodromo_llegada_id = aerodromo2.aerodromo_id
                  AND fpl.propuesta_vuelo_id = propuestavuelo.propuesta_vuelo_id
                  AND propuestavuelo.codigo_compania = compania.codigo_compania
                  AND DATE(fpl.fecha_llegada) >= '$fecha_1' AND DATE(fpl.fecha_llegada) <= '$fecha_2'
                  UNION
                  SELECT fpl.codigo, compania.nombre_compania, fpl.fecha_salida, fpl.fecha_llegada, fpl.codigo_aeronave,
                  aerodromo.nombre AS aero_salida, aerodromo2.nombre AS aero_llegada, fpl.propuesta_vuelo_id,
                  fpl.aerodromo_salida_id, fpl.aerodromo_llegada_id
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
                  aerodromo.nombre AS aero_salida, aerodromo2.nombre AS aero_llegada, fpl.propuesta_vuelo_id,
                  fpl.aerodromo_salida_id, fpl.aerodromo_llegada_id
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

<h1 class="title">ADMIN</h1>

<div class="level box">
    <div class="level-left">
        <div class='level-item'>
            <h1 class="title is-black">Filtrar</h1>
        </div>
    </div>
    <form action="" method="GET">
        <div class="level-right">        
            <label for="fecha_1" class="level-item"><strong>Fecha Inicial</strong></label>
            <input type="date" name="fecha_1" id="fecha_1" class="button level-item">
            <label for="fecha_2" class="level-item"><strong>Fecha Final</strong></label>
            <input type="date" name="fecha_2" id="fecha_2" class="button level-item">
            <button class="button is-info level-item">Buscar Vuelos</button>
        </div>
    </form>
</div>

<div class="">
    <table class="table is-bordered is-hoverable is-fullwidth">
        <thead class="has-background-grey-dark">
            <tr>
                <th scope="col" class="has-text-white">Codigo Vuelo</th>
                <th scope="col" class="has-text-white">Compañia</th>
                <th scope="col" class="has-text-white">Fecha Salida</th>
                <th scope="col" class="has-text-white">Fecha Llegada</th>
                <th scope="col" class="has-text-white">Codigo Aeronave</th>
                <th scope="col" class="has-text-white">Aerodromo Salida</th>
                <th scope="col" class="has-text-white">Aerodromo Llegada</th>
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
                        <td>$vuelo[5] (ID: $vuelo[8])</td>
                        <td>$vuelo[6] (ID: $vuelo[9])</td>
                        <td class='level'>
                            <form method='POST' action='../funciones/admin_vuelos.php'>
                                <input type='hidden' name='id_vuelo' value='$vuelo[7]'>
                                <input type='submit' name='estado' value='aceptar' class='button is-success'/>
                            </form>
                            <form method='POST' action='../funciones/admin_vuelos.php'>
                                <input type='hidden' name='id_vuelo' value='$vuelo[7]'>
                                <input type='submit' name='estado' value='rechazar' class='button is-danger'/>
                            </form>
                        </td>
                      </tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</div>
</body>
</html>