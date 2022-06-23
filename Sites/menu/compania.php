<?php
    include('../templates/header.html'); 
    session_start();
    $compania = $_SESSION["user"];
    if (is_null($compania)) {
        header("Location: https://codd.ing.puc.cl/~grupo57/index.php?");
        exit();
    }
    echo "<h1>Vuelos de $compania</h1>";

    require("../config/conexion.php");

    $query = "SELECT vuelos.fechasalida, vuelos.codigovuelo, vuelos.llegadaicao
                FROM vuelos
                WHERE vuelos.codigoca = '$compania' AND vuelos.estado = 'aceptado';";
    $result = $db1 -> prepare($query);
    $result -> execute();    
    $ca_aprobado = $result -> fetchAll();

    $query_2 = "SELECT vuelos.fechasalida, vuelos.codigovuelo, vuelos.llegadaicao 
                FROM vuelos
                WHERE vuelos.codigoca = '$compania' AND vuelos.estado = 'rechazado';";
    $result_2 = $db1 -> prepare($query_2);
    $result_2 -> execute();    
    $ca_rechazado = $result_2 -> fetchAll();
?>

<div style="margin-right:50px; margin-left:50px;" >
    <p>Vuelos aprobados</p>
    <table align="center" class="table table-bordered" margin:4px style="width:100%">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Fecha Salida</th>
            <th scope="col">Codigo Vuelo</th>
            <th scope="col">Codigo ICAO Aerodromo Llegada</th>
        </tr>
        </thead>
        <tbody>
            <?php
            foreach($ca_aprobado as $vuelo){
                echo "<tr><td>$vuelo[0]</td><td>$vuelo[1]</td><td>$vuelo[2]</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
<div style="margin-right:50px; margin-left:50px;" >
    <p>Vuelos rechazados</p>
    <table align="center" class="table table-bordered" margin:4px style="width:100%">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Fecha Salida</th>
            <th scope="col">Codigo Vuelo</th>
            <th scope="col">Codigo ICAO Aerodromo Llegada</th>
        </tr>
        </thead>
        <tbody>
            <?php
            foreach($ca_rechazado as $vuelo){
                echo "<tr><td>$vuelo[0]</td><td>$vuelo[1]</td><td>$vuelo[2]</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>    

<?php include('../templates/footer.html'); ?>