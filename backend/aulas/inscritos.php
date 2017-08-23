<?php
    require '../utils/basics.php';

    session_start();

    $obj = json_decode(file_get_contents("php://input"));
    $aula = $obj->aula;

    $query = "SELECT GROUP_CONCAT(user.nome) AS strInscritos, GROUP_CONCAT(user.email) AS strEmail FROM aula INNER JOIN aula_user ON aula.id = aula_user.id_aula INNER JOIN user ON aula_user.id_user = user.id WHERE aula.id = '$aula' GROUP BY aula.id";

	$conexao = conecta();

	if(!$conexao){
		die("Conexao nao pode ser feita");
	}

	$db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
	if(!$db_selected){
		die("Database não pode ser usada");
	}
    $insert = mysqli_query($conexao, $query);

    if($insert){
        $aula = [];
        while($row = mysqli_fetch_assoc($insert)){
            array_push($aula, $row);
        }

        $aula = json_encode($aula, JSON_UNESCAPED_UNICODE);

        echo $aula;
    } else {
        echo false;    
    }
    desconecta($conexao);
?>