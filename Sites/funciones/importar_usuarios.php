<?php
    require("../config/conexion.php");

    // Query usuarios totales en db
    $query_usuarios = "SELECT *
                       FROM usuarios;";
    $result_usuarios = $db1 -> prepare($query_usuarios);
    $result_usuarios -> execute();
    $usuarios = $result_usuarios -> fetchAll();

    $n_usuarios = sizeof($usuarios);

    // Query para el usuario DGAC
    $query_admin = "SELECT id, username, contraseña, tipo
                    FROM usuarios
                    WHERE username like '%DGAC%';";
    $result_admin = $db1 -> prepare($query_admin);
    $result_admin -> execute();
    $admin = $result_admin -> fetchAll();

    // Añadir DGAC a la base de datos si es que no se encuentra
    if (count($admin) == 0) {
        $id = $n_usuarios+1;
        $n_usuarios = $n_usuarios+1;
        $admin_q = "INSERT INTO usuarios (id, username, contraseña, tipo)
                    VALUES ('$id', 'DGAC', 'admin', 'admin dgac');";
        try {
            $db1 ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db1 -> exec($admin_q);
            echo "New record created successfully";
        } catch(PDOException $e) {
            echo "<br>";
        }
    }

    // Query usuarios compañia aerea en db
    $query_usuarios_ca = "SELECT id, username, contraseña, tipo
                          FROM usuarios
                          WHERE tipo like '%compania aerea%';";
    $result_usuarios_ca = $db1 -> prepare($query_usuarios_ca);
    $result_usuarios_ca -> execute();
    $usuarios_ca = $result_usuarios_ca -> fetchAll();

    // Array de username de usuarios compañia aerea
    $array_usuarios_ca = array();
    foreach ($usuarios_ca as $compania) {
        array_push($array_usuarios_ca, $compania[1]);
    }

    // Query de compañias aereas en db
    $query_ca = "SELECT *
                 FROM companiaaerea;";
    $result_ca = $db1 -> prepare($query_ca);
    $result_ca -> execute();
    $codigos_ca = $result_ca -> fetchAll();

    // array de compañias aereas
    $array_ca = array();
    foreach ($codigos_ca as $compania) {
        array_push($array_ca, array($compania[0], $compania[1]));
    }

    // ingresar usuarios ca a db con password al azar
    foreach ($array_ca as $compania) {
        if (!(in_array($compania[0], $array_usuarios_ca))) {
            $id = $n_usuarios+1;
            $n_usuarios = $n_usuarios+1;
            $pwd = bin2hex(openssl_random_pseudo_bytes(4));
            // echo $id;
            // echo $compania[0];
            // echo " ";
            // echo $compania[1];
            // echo "<br>";
            $user_ca = "INSERT INTO usuarios (id, username, contraseña, tipo)
                        VALUES ('$id', '$compania[0]', '$pwd', 'compania aerea');";
            try {
                $db1 ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db1 -> exec($user_ca);
            } catch(PDOException $e) {
                echo "<br>";
            }
        }
    }

    // Query usuarios compañia aerea en db
    $query_usuarios_pasajero = "SELECT id, username, contraseña, tipo
                                FROM usuarios
                                WHERE tipo like '%pasajero%';";
    $result_usuarios_pasajero = $db1 -> prepare($query_usuarios_pasajero);
    $result_usuarios_pasajero -> execute();
    $usuarios_pasajero = $result_usuarios_pasajero -> fetchAll();

    // Array de username de usuarios pasajero
    $array_usuarios_pasajero = array();
    foreach ($usuarios_pasajero as $pasajero) {
        array_push($array_usuarios_pasajero, $pasajero[1]);
    }

    // Query de pasajeros en db
    $query_pasajero = "SELECT *
                       FROM pasajero;";
    $result_pasajero = $db1 -> prepare($query_pasajero);
    $result_pasajero -> execute();
    $pasajeros = $result_pasajero -> fetchAll();

    // array de pasajeros
    $array_pasajeros = array();
    foreach ($pasajeros as $pasajero) {
        // echo "$pasajero[0] $pasajero[1]";
        // echo "<br>";
        array_push($array_pasajeros, array($pasajero[0], $pasajero[1]));
    }
    print_r($array_usuarios_pasajero);

    // ingresar usuarios ca a db con password al azar
    foreach ($array_pasajeros as $pasajero) {
        if (!(in_array($pasajero[0], $array_usuarios_pasajero))) {
            $id = $n_usuarios+1;
            $n_usuarios = $n_usuarios+1;
            // echo $id;
            // echo " ";
            // echo $pasajero[0];
            // echo " ";
            // echo $pasajero[1];
            $pasaporte = $pasajero[0];
            $nombre = $pasajero[1];
            $nombre = str_replace(' ', '', $nombre);
            $largo_psw = random_int(6, 12);
            $str = $pasaporte . $nombre ;
            $pwd = substr(str_shuffle($str), 0, $largo_psw);
            // echo " ";
            // echo $pswrd;
            // echo "<br>";
            $user_pasajero = "INSERT INTO usuarios (id, username, contraseña, tipo)
                              VALUES ('$id', '$pasaporte', '$pwd', 'pasajero');";
            try {
                $db1 ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $db1 -> exec($user_pasajero);
            } catch(PDOException $e) {
                echo "<br>";
            }
        }
    }
?>