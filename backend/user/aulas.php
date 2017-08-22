<?php
    require '../utils/basics.php';

    session_start();

    $id = $_SESSION['ID'];

    $conexao = $_COOKIE['conexao'];
    if(!$conexao){
        die("Conexao nao pode ser feita");
    }

    $query = "SELECT * FROM aula_user WHERE id_user = '$id'";

    $select = mysqli_query($conexao, $query);
    if($select){
        $resposta = [];
        while($row = mysqli_fetch_assoc($select)){
            array_push($resposta, $row['id_aula']);
        }
        echo json_encode($resposta);
    } else {
        echo false;
    }
    
    desconecta($conexao);
?>