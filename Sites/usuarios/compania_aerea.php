<?php include('../templates/header.html'); ?>

<body>
<h1 align="center">Número de vuelos en cada estado por compañía aérea</h1>
<br>
<?php
    $compania2= $_POST["codigoaerolinea"];
    // echo "$compania";
    require("../config/conexion.php");
    $compania = strtoupper($compania2);


    // $query = "SELECT *
    $query = "SELECT vuelos.fechasalida, vuelos.codigovuelo, vuelos.llegadaicao
                FROM vuelos
                LEFT JOIN companiaaerea
                ON companiaaerea.codigoca = vuelos.codigoca
                WHERE companiaaerea.codigoca like '%$compania%' AND vuelos.estado like '%aceptado%'
                GROUP BY companiaaerea.codigoca"; // Crear la consulta
    $result = $db -> prepare($query);
    $result -> execute();    
    $ca_aprobado = $result -> fetchAll();

    $query_2 = "SELECT vuelos.fechasalida, vuelos.codigovuelo, vuelos.llegadaicao 
                FROM vuelos
                LEFT JOIN companiaaerea
                ON companiaaerea.codigoca = vuelos.codigoca
                WHERE companiaaerea.codigoca like '%$compania%' AND vuelos.estado like '%rechazado%'
                GROUP BY companiaaerea.codigoca"; // Crear la consulta
    $result_2 = $db -> prepare($query_2);
    $result_2 -> execute();    
    $ca_rechazado = $result -> fetchAll();

    // print_r($vuelos)


    // print_r($vuelos)
    ?>
   <div style="margin-right:50px; margin-left:50px;" >
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