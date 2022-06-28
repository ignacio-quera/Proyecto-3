<?php
    session_start();
    require("../config/conexion.php");

    $username = $_SESSION["user"];
    $password = $_SESSION["password"];

    $query = "SELECT tipo
                FROM usuarios
                WHERE username = '$username' AND contraseña = '$password';";
    $result = $db1 -> prepare($query);
    $result -> execute();
    $data = $result -> fetch();
    
    if ($data[0] == 'compania aerea') {
        header("Location: ../menu/compania.php");
        exit();
    } elseif ($data[0] == 'admin dgac') {
        header("Location: ../menu/admin.php");
        exit();
    } elseif ($data[0] == 'pasajero') {
        header("Location: ../menu/pasajero.php");
        exit();
    } else {
        session_destroy();
        header("Location: ../index.php");
        exit();
    }
?>