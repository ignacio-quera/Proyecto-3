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
    $query = "SELECT companiaaerea.codigoca, count(case when vuelos.estado like '%aceptado%' then 1 else null end) as aceptado,
            count(case when vuelos.estado like '%pendiente%' then 1 else null end) as pendiente,
            count(case when vuelos.estado like '%publicado%' then 1 else null end) as publicado,
            count(case when vuelos.estado like '%borrador%' then 1 else null end) as borrador,
            count(case when vuelos.estado like '%rechazado%' then 1 else null end) as rechazado
                FROM vuelos
                LEFT JOIN companiaaerea
                ON companiaaerea.codigoca = vuelos.codigoca
                WHERE companiaaerea.codigoca like '%$compania%'
                GROUP BY companiaaerea.codigoca"; // Crear la consulta
    $result = $db -> prepare($query);
    $result -> execute();    
    $vuelos = $result -> fetchAll();

    // print_r($vuelos)


    // print_r($vuelos)
    ?>
    <div style="margin-right:50px; margin-left:50px;" >
    <table align="center" class="table table-bordered" margin:4px style="width:100%">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Compañia Aerea</th>
            <th scope="col">Vuelos Aprobados</th>
            <th scope="col">Vuelos Pendiente</th>
            <th scope="col">Vuelos Publicados</th>
            <th scope="col">Vuelos Borradores</th>
            <th scope="col">Vuelos Rechazados</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach($vuelos as $vuelo){
            echo "<tr><td>$vuelo[0]</td><td>$vuelo[1]</td><td>$vuelo[2]</td><td>$vuelo[3]</td><td>$vuelo[4]</td><td>$vuelo[5]</td></tr>";
        }
        ?>
        </tbody>
    </table>
    </div>

    
<?php include('../templates/footer.html'); ?>