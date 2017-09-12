<?php
    require '../utils/basics.php';

    date_default_timezone_set("UTC");

    session_start();

    $obj = json_decode(file_get_contents("php://input"));
    $search = $obj->search;
    
    if($search == NULL)
        $search = "";

    $query = "SELECT *, GROUP_CONCAT(tags.nome) AS strTags, aula.id AS aulaId, aula.nome AS aulaNome, user.nome AS userNome FROM aula INNER JOIN aula_tags ON aula.id = aula_tags.id_aula INNER JOIN tags ON aula_tags.id_tag = tags.id INNER JOIN user ON user.id = aula.sensei WHERE aula.nome LIKE '%$search%' OR user.nome LIKE '%$search%' GROUP BY aula.id";
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
            if(strtotime($row['data']) > strtotime("now"))
                array_push($aula, $row);
        }

        $aula = json_encode($aula, JSON_UNESCAPED_UNICODE);

        echo $aula;
    } else {
        echo false;    
    }
    desconecta($conexao);
?>