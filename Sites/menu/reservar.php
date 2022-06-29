<?php
    session_start();
    $pasaporte = $_SESSION['user'];
    $origen = $_SESSION['origen'];
    $destino = $_SESSION['destino'];
    $fecha = $_SESSION['fecha'];
    if  (isset($_GET['codigo'])) {
        $codigo = $_GET['codigo'];
        $_SESSION['codigo'] = $codigo;
    }
    if (is_null($pasaporte)) {
        header("Location: https://codd.ing.puc.cl/~grupo57/index.php?");
        exit();
    }

    require("../config/conexion.php");

    if (!isset($_GET['pasaporte1']) || !isset($_GET['pasaporte2']) || !isset($_GET['pasaporte3'])) {
        $_GET['pasaporte1'] = '';
        $_GET['pasaporte2'] = '';
        $_GET['pasaporte3'] = '';
        $mensaje = null;    
    }    
    else  {
        $pasaporte1 = $_GET['pasaporte1'];
        $pasaporte2 = $_GET['pasaporte2'];
        $pasaporte3 = $_GET['pasaporte3'];
        $codigo = $_SESSION['codigo'];


        // echo "$origen, $destino, $fecha, $pasaporte, $pasaporte1, $pasaporte2, $pasaporte3";

        $query = "SELECT * from generar_reserva('$origen', '$destino', '$fecha', '$codigo', '$pasaporte',
                            '$pasaporte1', '$pasaporte2', '$pasaporte3');";
        $db1 ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $result = $db1 -> prepare($query);
        $result -> execute();
        $data = $result -> fetchAll();
        
        // print_r($data);
        $m = $data[0];
        $mensaje = $m[0];

    }

    include('../templates/header.html');
    ?>  

    <div class="level">
        <div class="level-left">
            <h1 class="title is-4 level-item">Ingrese los pasaportes para quienes desee hacer la reserva</h1>
        </div>
        <div class="level-right">
            <form action="busqueda_vuelos.php" method="get">
                <input type="submit" value="Volver" class="button">
            </form>
        </div>
    </div>
    
    <div class=" box is-flex is-align-items-center">
    <!-- action="/send.php"  poner lo anterior para mandar la info a otra página -->
        <form name="reserva" method="get">
        <input type="text" name="pasaporte1" id="pasaporte1" autocomplete="off"
                placeholder="Introducir Pasaporte" class="input"/>
        <br>
        <br>
        <input type="text" name="pasaporte2" id="pasaporte2" autocomplete="off"
                placeholder="Introducir Pasaporte" class="input"/>
        <br>
        <br>
        <input type="text" name="pasaporte3" id="pasaporte3" autocomplete="off"
                placeholder="Introducir Pasaporte" class="input"/>
        <br>
        <br>
        <input type="submit" value="Generar Reserva" class="button is-info">
        </form>
    
    </div>
    <br>
    
    <?php
                    if (!is_null($mensaje)) {
                        if ($mensaje == 'No se ingresaron pasajeros para reservar') {
                            echo '<script type="text/JavaScript"> 
                            alert("Se debe ingresar por lo menos un pasajero!");
                            </script>';
                        }
                        elseif ($mensaje =='No existen pasajeros con el primer pasaporte') {
                            echo '<script type="text/JavaScript"> 
                            alert("El primer pasaporte no existe!");
                            </script>';
                        } elseif ($mensaje =='No existen pasajeros con el segundo pasaporte') {
                            echo '<script type="text/JavaScript"> 
                            alert("El segundo pasaporte no existe!");
                            </script>';
                        } elseif ($mensaje == 'No existen pasajeros con el tercer pasaporte') {
                            echo '<script type="text/JavaScript"> 
                            alert("El tercer pasaporte no existe!");
                            </script>';
                        } elseif ($mensaje == "Choque temporal del pasajero de pasaporte $pasaporte1") {
                            echo '<script type="text/JavaScript"> 
                            alert("El pasajero de la primera entrada tiene un tope con otro vuelo!");
                            </script>';
                        } elseif ($mensaje == "Choque temporal del pasajero de pasaporte $pasaporte2") {
                            echo '<script type="text/JavaScript"> 
                            alert(`El pasajero de la segunda entrada tiene un tope con otro vuelo!`);
                            </script>';
                        } elseif ($mensaje == "Choque temporal del pasajero de pasaporte $pasaporte3") {
                            echo '<script type="text/JavaScript"> 
                            alert("El pasajero de la tercera entrada tiene un tope con otro vuelo!");
                            </script>';
                        } elseif ($mensaje == 'reserva creada') {
                            echo '<script type="text/JavaScript"> 
                            alert("La reserva fue creada con éxito!");
                            </script>';
                        } 
                    }
                        
                ?>
    
    </div>
    </body>
    </html>
