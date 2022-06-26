<?php include('../templates/header.html'); ?>

<body>
<h1 align="center">Vuelos Pendientes</h1>
<br>
<?php
    require("../config/conexion.php");

    // $query = "SELECT *
    $query = "SELECT fechasalida , codigovuelo, codigoca
                FROM vuelos
                WHERE estado LIKE '%pendiente%'"; // Crear la consulta
    $result = $db -> prepare($query);
    $result -> execute();    
    $vuelos = $result -> fetchAll();

    print_r($vuelos)
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

    
<?php include('../templates/footer.html'); ?>