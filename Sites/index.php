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
        "user": document.getElementById('input-user').value,
        "pass": document.getElementById('input-pass').value
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
    div.transbox {
      margin: 30px;
      background-color: #ffffff;
      opacity: 0.6;
    }

    div.transbox h1 {
      margin: 5%;
      opacity: 1;
      font-weight: bold;
      color: #000000;
    }

    h1 span { 
      color: white; 
      font-size: 37px;
      letter-spacing: -1px;  
      background: rgb(0, 0, 0); /* fallback color */
      background: rgba(0, 0, 0, 0.7);
      padding: 10px; 
      border-radius: 25px;
    }

    form span { 
      background: rgb(0, 0, 0); /* fallback color */
      background: rgba(0, 0, 0, 0.7);
      padding: 10px; 
      border-radius: 25px;
    }

    h3 span{ 
      color: white;
      font-size: 27px; 
      letter-spacing: -1px;  
      background: rgb(0, 0, 0); /* fallback color */
      background: rgba(0, 0, 0, 0.7);
      padding: 5px; 
      border-radius: 25px;
    }

    section {
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 80px, 100px;
      color = white   
    }

    .form-center {
      display:flex;
      justify-content: center;
    }
  </style>
</head>

<?php
  session_start();
  $_SESSION["user"] = null;
  $_SESSION["password"] = null;
?>

<body style="background-image: url('https://img.freepik.com/free-photo/model-plane-airplane-blue-background-flat-lay-design-travel-vacation-concept_152898-4815.jpg'); background-size: cover;">
  <nav class="navbar navbar-expand-lg py-3 navbar-dark bg-dark shadow-sm">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container">
      <a href="#" class="navbar-brand">
        <!-- Logo Image -->
        <img src="images/logov2.png" width="55" alt="" class="d-inline-block align-middle mr-2">
        <span class="navbar-brand mb-0 h1">Consultas Aerolineas</span></a>

    </div>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
        <span class="navbar-brand mb-0 h1" id="spantest"></span>
        </li>
        <li class="nav-item active">
        <button type="button" class="b1" onclick="importar()">Importar Usuarios</button>   
        </li>
      </ul>
    </div>
  </nav>

  <br>
  <br>
  <div id="divtest"><h2 align="center"><span>Log In</span></h2></div>
  <br>

  <div class="form-center">
    <form align="center" method = 'post' >
        Username:
        <input id="input-user" type="text" name="user" placeholder="Usuario">
        <br><br>
        Contraseña:
        <input id="input-pass" type="password" name="pass" placeholder="*****">
        <br><br>
        <input id="clickMe" type="button" value="Ingresar" onclick="login();" />
    </form>
  </div>
</body>
</html>