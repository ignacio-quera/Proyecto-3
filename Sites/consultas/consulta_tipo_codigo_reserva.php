<?php include('../templates/header.html'); ?>

<body>
<?php
    require("../config/conexion.php");

    $reserva1 = $_POST["codigoreserva"];
    $reserva = strtoupper($reserva1);
    // echo "reserva = $reserva";
    echo "<h1 align='center'>Tickets, pasajeros y costos dado el código de reserva " . $reserva . "</h1>";

    // $query = "SELECT *
    $query = "SELECT ticket.idticket, pasajero.npasaporte, costo.precio
                FROM reserva
                LEFT JOIN ticket on reserva.idticket = ticket.idticket
                LEFT JOIN costo on ticket.idcosto = costo.idcosto
                LEFT JOIN pasajero on reserva.npasaportereservado = pasajero.npasaporte
                WHERE reserva.codigoreserva like '%$reserva%'"; // Crear la consulta
    $result = $db -> prepare($query);
    $result -> execute();    
    $vuelos = $result -> fetchAll();

    // print_r($vuelos)
    ?>
    <br>
    <div style="margin-right:50px; margin-left:50px;" >
    <table align="center" class="table table-bordered" margin:4px style="width:100%">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Tickets</th>
            <th scope="col">Pasaporte  Pasajero</th>
            <th scope="col">Precio</th>
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
