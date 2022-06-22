<?php
    require("../config/conexion.php");

    $username = $_POST["user"];
    $password = $_POST["pass"];

    if ($username == "success") {
        echo json_encode(array("abc" => "text"));
        
    }

?>