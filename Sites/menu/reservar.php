<?php
    session_start();
    $pasaporte = $_SESSION['user'];
    if (is_null($pasaporte)) {
        header("Location: https://codd.ing.puc.cl/~grupo57/index.php?");
        exit();
    }
    include('../templates/header.html');
?>

<h1 align="center">Ingrese Los Pasaportes Para</h1>
<h1 align="center">Quienes Desee Hacer La Reserva</h1>
<br>

<div style="margin-right:50px; margin-left:50px;" >

<!-- action="/send.php"  poner lo anterior para mandar la info a otra página -->
    <form align="center" name="reserva1" method="post">
    <input type="text" name="pasaporte1" autocomplete="off"
            placeholder="Introducir Pasaporte" />
    </form>
    <br>
    <form align="center" name="reserva2" method="post">
    <input type="text" name="pasaporte2" autocomplete="off"
            placeholder="Introducir Pasaporte" />
    </form>
    <br>
    <form align="center" name="reserva3" method="post">
    <input type="text" name="pasaporte3" autocomplete="off"
            placeholder="Introducir Pasaporte" />
    </form>
    <br>
    <form align="center" method="get">
    <input type="submit" value="Generar Reserva">
    </form>

</div>
<br>
<form align="center" action="busqueda_vuelos.php" method="get">
    <input type="submit" value="Volver">
</form>
</body>
</html>