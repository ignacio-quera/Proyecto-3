<?php include('../templates/header.html'); ?>

<body>

<?php
    require("../config/conexion.php");
    // print_r($_POST);
    $icao2 = $_POST["codigoicao"];
    $icao = strtoupper($icao2);
    $compania = $_POST["compania"];
    // echo "$compania";

    echo "<h1 align='center'>Vuelos Aceptados de la aerolínea " . $compania . " con destino al aeropuerto de código " . $icao ."</h1>";

    // $query = "SELECT *
    $query = "SELECT vuelos.fechasalida , vuelos.codigovuelo, vuelos.codigoca
                FROM vuelos
                WHERE vuelos.estado LIKE '%aceptado%'
                AND vuelos.llegadaicao LIKE '%$icao%'
                AND vuelos.codigoca LIKE '%$compania%'"; // Crear la consulta
    $result = $db -> prepare($query);
    $result -> execute();    
    $vuelos = $result -> fetchAll();

    // print_r($vuelos)
    ?>

    <div style="margin-right:50px; margin-left:50px;" >
    <table align="center" class="table table-bordered" margin:4px style="width:100%">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Fecha Salida</th>
            <th scope="col">Codigo Vuelo</th>
            <th scope="col">Codigo Compañia Aerea</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($vuelos as $vuelo){
            echo "<tr><td>$vuelo[0]</td><td>$vuelo[1]</td><td>$vuelo[2]</td></tr>";
        }
        ?>
        </tbody>
    </table>
    </div>
    <!--  -->
    

    <?php include('../templates/footer.html'); ?>
