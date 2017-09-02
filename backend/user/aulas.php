<?php
    require '../utils/basics.php';

    session_start();

    $id = $_SESSION['ID'];

	$conexao = conecta();

	if(!$conexao){
		die("Conexao nao pode ser feita");
	}

	$db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
	if(!$db_selected){
		die("Database não pode ser usada");
	}

    $query = "SELECT *, GROUP_CONCAT(DISTINCT tags.nome) AS strTags, aula.id AS aulaId, aula.nome AS aulaNome, user.nome AS userNome FROM aula_user INNER JOIN aula ON aula.id = aula_user.id_aula INNER JOIN aula_tags ON aula.id = aula_tags.id_aula INNER JOIN tags ON aula_tags.id_tag = tags.id INNER JOIN user ON user.id = aula.sensei WHERE aula_user.id_user='$id' GROUP BY aula.id";

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