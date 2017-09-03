<?php
    require '../utils/basics.php';

    session_start();

    $obj = json_decode(file_get_contents("php://input"));

    $user = $obj->user;
    $aula = $obj->aula;

	$conexao = conecta();
    if(!$conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
    if(!$db_selected){
        die("Database não pode ser usada");
    }
    $query1 = "DELETE FROM aula_user WHERE id_aula = '$aula' AND id_user = '$user'";
    $select = mysqli_query($conexao, $query1);

    if($select){
        $query2 = "UPDATE aula SET capacidade = capacidade + 1 WHERE id = '$aula'";
        $select2 = mysqli_query($conexao, $query2);

        if($select){
            echo true;
        } else {
            echo false;
        }
    } else {
        echo false;
    }
    
    desconecta($conexao);
?>