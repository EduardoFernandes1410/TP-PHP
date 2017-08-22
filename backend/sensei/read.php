<?php
    require '../utils/basics.php';

    session_start();

    $obj = json_decode(file_get_contents("php://input"));

    $id = $obj->id;

	$conexao = conecta();

	if(!$conexao){
		die("Conexao nao pode ser feita");
	}

	$db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
	if(!$db_selected){
		die("Database não pode ser usada");
	}

    $query = "SELECT * FROM user WHERE id = '$id'";

    $select = mysqli_query($conexao, $query);
    if($select){
        $resposta = [];
        while($row = mysqli_fetch_assoc($select)){
            array_push($resposta, $row);
        }
        echo json_encode($resposta);
    } else {
        echo false;
    }
    
    desconecta($conexao);
?>