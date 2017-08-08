<?php
    require '../utils/basics.php';

    session_start();

    $conexao = conecta();
    if(!$conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    $query = "SELECT * FROM aula";

    $insert = mysqli_query($conexao, $query);

    if($insert){
        $aula = [];
        while($row = mysqli_fetch_assoc($insert)){
            array_push($aula,$row);
        }
        echo json_encode($aula);
    } else {
        echo false;    
    }
    desconecta($conexao);
?>