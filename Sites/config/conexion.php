<?php
    try {
        require('data.php');
        $db1 = new PDO("pgsql:dbname=$databaseName1;host=localhost;port=5432;user=$user1;password=$password1");
        $db2 = new PDO("pgsql:dbname=$databaseName2;host=localhost;port=5432;user=$user2;password=$password2");
    } catch (Exception $e){
        echo "No se pudo conectar a la base de datos: $e";  
    }
?>