<?php
    session_start();
    $pasaporte = $_SESSION['user'];
    if (is_null($pasaporte)) {
        header("Location: ../index.php");
        exit();
    }
    include('../templates/header.html');
?>

<p>Hola</p>

<br>
<br>

<form align="center" action="busqueda_vuelos.php" method="get">
    <input type="submit" value="Volver">
</form>
</body>
</html>