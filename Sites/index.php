<?php
    session_start();
    if (isset($_SESSION['user']) && isset($_SESSION['password'])) {
        header("Location: funciones/checklogin.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Entrega 3 BBDD</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/scrollreveal"></script>

    <script>
        function importar(){
        document.getElementById("spantest").textContent="Usuarios Importados!";
        $.ajax({
            type: "POST",
            url: "funciones/importar_usuarios.php",
        });
        };

        function login(){
        var parametros = {
            "user": document.getElementById('username').value,
            "pass": document.getElementById('password').value
        };
        $.ajax({
            type: "POST",
            url: "funciones/login.php",
            data: parametros,
            success: function(respuesta){
            window.location = respuesta;
            }
        });
        }
    </script>

    <style>
        .form-center {
        display:flex;
        justify-content: center;
        }
    </style>
</head>

<body style="background-image: url('https://img.freepik.com/free-photo/model-plane-airplane-blue-background-flat-lay-design-travel-vacation-concept_152898-4815.jpg'); background-size: cover;">
    <nav class="navbar navbar-expand-lg py-3 navbar-dark bg-dark shadow-sm">
    <div class="container">
        <div class="navbar-brand">
            <img src="images/logov2.png" width="55" alt="" class="d-inline-block align-middle mr-2">
            <span aling = "center" style = "font-size: 40px;"class="text-uppercase font-weight-bold">Consultas Aerolíneas</span>
        </div>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <span class="navbar-brand mb-0 h1" id="spantest"></span>
            </li>
            <li class="nav-item active">
                <button type="button" class="btn btn-info" onclick="importar()">Importar Usuarios</button>
            </li>
        </ul>
    </div>
    </nav>
    <br>
    <br>

    <div class="text-center">
        <h2>Log In</h2>
    </div>
    <br>

    <div class="form-center">
        <div>
            <form method = 'post' >
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="user" class="form-control" id="username" placeholder="Usuario">
                </div>
                <div class="form-group">
                    <label for="password">Contraseña:</label>
                    <input type="password" name="pass" class="form-control" id="password" placeholder="*****">
                </div>
                <input id="clickMe" type="button" value="Ingresar" onclick="login();" class="btn btn-primary"/>
            </form>
        </div>
    </div>
</body>
</html>