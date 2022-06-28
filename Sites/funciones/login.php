<?php
    session_start();
    require("../config/conexion.php");

    $username = $_POST["user"];
    $password = $_POST["pass"];

    $query = "SELECT tipo
                FROM usuarios
                WHERE username = '$username' AND contraseña = '$password';";
    $result = $db1 -> prepare($query);
    $result -> execute();
    $data = $result -> fetch();
    $_SESSION["user"] = $username;
    $_SESSION["password"] = $password;

    if ($data[0] == 'compania aerea') {
        echo 'menu/compania.php';
    } elseif ($data[0] == 'admin dgac') {
        echo 'menu/admin.php';
    } elseif ($data[0] == 'pasajero') {
        echo 'menu/pasajero.php';
    }

?>