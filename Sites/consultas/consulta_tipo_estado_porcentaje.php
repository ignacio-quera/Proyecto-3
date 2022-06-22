<?php include('../templates/header.html'); ?>

<body>
<h1 align="center">Compañia Aerea con el mayor porcentaje de vuelos aprobados</h1>
<br>
<?php
    require("../config/conexion.php");

    // $query = "SELECT *
    $query = "SELECT vuelos.codigoca, count(case when vuelos.estado like '%aceptado%' then 1 else null end) as sum, count(vuelos.estado) as sumtotal,
                100*count(case when vuelos.estado like '%aceptado%' then 1 else null end)/count(vuelos.estado) as percent
                FROM vuelos
                LEFT JOIN companiaaerea
                ON companiaaerea.codigoca = vuelos.codigoca
                GROUP BY vuelos.codigoca
                ORDER BY 100*count(case when vuelos.estado like '%aceptado%' then 1 else null end)/count(vuelos.estado) DESC
                LIMIT 1"; // Crear la consulta
    $result = $db -> prepare($query);
    $result -> execute();    
    $vuelos = $result -> fetchAll();

    // print_r($vuelos)
    ?>

    <div style="margin-right:50px; margin-left:50px;" >
    <table align="center" class="table table-bordered" margin:4px style="width:100%">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Compañia Aerea</th>
            <th scope="col">Vuelos Aprobados</th>
            <th scope="col">Vuelos Totales</th>
            <th scope="col">Porcentaje</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($vuelos as $vuelo){
            echo "<tr><td>$vuelo[0]</td><td>$vuelo[1]</td><td>$vuelo[2]</td><td>$vuelo[3]</td></tr>";
        }
        ?>
        </tbody>
    </table>
    </div>


    
<?php include('../templates/footer.html'); ?>