<?php
    require("../config/conexion.php");

    $username = $_POST["user"];
    $password = $_POST["pass"];

    $query = "SELECT tipo
                FROM usuarios
                WHERE username = '$username' AND contraseña = '$password';";
    $result = $db -> prepare($query);
    $result -> execute();
    $data = $result -> fetchAll();

    if ($data[0][0] == 'compania aerea') {
        echo 'compania.php';
    } elseif ($data[0][0] == 'admin dgac') {
        echo 'admin.php';
    } elseif ($data[0][0] == 'pasajero') {
        echo 'pasajero.php';
    }

?>