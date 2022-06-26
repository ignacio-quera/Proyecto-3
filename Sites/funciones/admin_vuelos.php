<?php
    require("../config/conexion.php");

    $id_vuelo = $_POST['id_vuelo'];

    // Buscar vuelo
    $query = "SELECT fpl.codigo, propuestavuelo.codigo_compania, fpl.fecha_salida,
              fpl.fecha_llegada, fpl.velocidad, fpl.altitud, fpl.ruta_id, fpl.codigo_aeronave,
              aerodromo.codigo_ICAO, aerodromo2.codigo_ICAO
              FROM fpl, propuestavuelo, aerodromo, aerodromo AS aerodromo2
              WHERE fpl.propuesta_vuelo_id = '$id_vuelo'
              AND fpl.aerodromo_salida_id = aerodromo.aerodromo_id
              AND fpl.aerodromo_llegada_id = aerodromo2.aerodromo_id
              AND fpl.propuesta_vuelo_id = propuestavuelo.propuesta_vuelo_id;";
    $result = $db2 -> prepare($query);
    $result -> execute();
    $data = $result -> fetchAll();

    // Buscar id
    $queryid = "SELECT MAX(vuelos.idvuelo)
              FROM vuelos;";
    $resultid = $db1 -> prepare($queryid);
    $resultid -> execute();
    $id_max = $resultid -> fetchAll();

    if($_POST['estado'] == 'aceptar'){
        $query1 = "UPDATE fpl
                   SET estado = 'aceptado'
                   WHERE fpl.propuesta_vuelo_id = '$id_vuelo';";
        //$result1 = $db2 -> prepare($query1);
        //$result1 -> execute();

        $query2 = "INSERT INTO TABLE vuelos VALUES(
                   '$data[0][0]', '$data[0][1]', '$data[0][2]', '$data[0][3]', '$data[0][4]',
                   '$data[0][5]', '$data[0][6]', '$data[0][7]', '$data[0][8]', '$data[0][9]',
                   'aceptado');";
    } elseif ($_POST['estado'] == 'rechazar') {
        $query1 = "UPDATE fpl
                   SET estado = 'rechazado'
                   WHERE fpl.propuesta_vuelo_id = '$id_vuelo';";
        //$result1 = $db2 -> prepare($query1);
        //$result1 -> execute();

        $query2 = "INSERT INTO TABLE vuelos VALUES(
                   '$data[0][0]', '$data[0][1]', '$data[0][2]', '$data[0][3]', '$data[0][4]',
                   '$data[0][5]', '$data[0][6]', '$data[0][7]', '$data[0][8]', '$data[0][9]',
                   'rechazado');";
    }

    //header("Location: ../menu/admin.php");
    //exit();
    echo $id_max[0][0] + 1;
?>