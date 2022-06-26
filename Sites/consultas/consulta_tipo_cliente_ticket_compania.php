<?php include('../templates/header.html'); ?>

<body>
<h1 align="center">Clientes con más tickets comprados por aerolínea</h1>
<br>
<?php
    require("../config/conexion.php");

    // $query = "SELECT *
    $query = "SELECT ca, np, tickets FROM(
                SELECT companiaaerea.codigoca as ca, r1.npasaportereservador as np, count(r1.idticket) as tickets,
                rank() over (partition by companiaaerea.codigoca  order by count(r1.idticket) desc) as rank_cliente 
                FROM reserva as r1
                INNER JOIN ticket on r1.idticket = ticket.idticket
                INNER JOIN pasajero on r1.npasaportereservador = pasajero.npasaporte
                INNER JOIN vuelos on ticket.idvuelo = vuelos.idvuelo
                INNER JOIN companiaaerea on vuelos.codigoca = companiaaerea.codigoca
                GROUP BY companiaaerea.codigoca, r1.npasaportereservador
                ORDER BY companiaaerea.codigoca) rank
                WHERE rank_cliente <= 1
                "; // Crear la consulta
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
            <th scope="col">Pasaporte Cliente</th>
            <th scope="col">Tickets comprados</th>
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