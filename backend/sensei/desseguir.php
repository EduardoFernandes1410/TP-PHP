<?php
    require '../utils/basics.php';

    session_start();

    $obj = json_decode(file_get_contents("php://input"));

    $user = $_SESSION['ID'];
    $sensei = $obj->sensei;

	$conexao = conecta();

	if(!$conexao){
		die("Conexao nao pode ser feita");
	}

	$db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
	if(!$db_selected){
		die("Database não pode ser usada");
	}

    $query = "DELETE FROM user_sensei WHERE id_user = '$user' AND id_sensei = '$sensei';";

    $select = mysqli_query($conexao, $query);
    if($select){
        echo true;
    } else {
        echo false;
    }
    
    desconecta($conexao);
?>