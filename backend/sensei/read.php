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

    $query = "SELECT *, AVG(notas.nota) AS media_notas FROM user INNER JOIN notas ON user.id = notas.id_sensei WHERE user.id = '$id'";

    $query2 = "SELECT COUNT(user_sensei.id_user) AS seguidores FROM user_sensei WHERE user_sensei.id_sensei = '$id'";


    $select = mysqli_query($conexao, $query);
    if($select){
        $resposta = [];
        while($row = mysqli_fetch_assoc($select)){
            array_push($resposta, $row);
        }

        $select2 = mysqli_query($conexao, $query2);
        if($select2){
            while($row = mysqli_fetch_assoc($select2)){
                $resposta[0]['seguidores'] = $row['seguidores'];
            }
        } else {
            echo false;
        }

        echo json_encode($resposta);
    } else {
        echo false;
    }
    
    desconecta($conexao);
?>