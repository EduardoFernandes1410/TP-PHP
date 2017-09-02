<?php
    require '../utils/basics.php';

    session_start();

    $obj = json_decode(file_get_contents("php://input"));

    $sensei = $obj->sensei;
    $gafanhoto = $obj->gafanhoto;
    $nota = $obj->nota;

	$conexao = conecta();

	if(!$conexao){
		die("Conexao nao pode ser feita");
	}

	$db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
	if(!$db_selected){
		die("Database não pode ser usada");
	}

    //Zera a nota dada
    $query1 = "DELETE FROM notas WHERE id_sensei = '$sensei' and id_gafanhoto='$gafanhoto'";
    $select = mysqli_query($conexao, $query1);
    
    //Dar nota nova
    $query = "INSERT INTO notas (id_gafanhoto, id_sensei, nota) VALUES ('$gafanhoto', '$sensei', '$nota')";

    $insert = mysqli_query($conexao, $query);

    if($insert){
        echo "1";
    } else {
        echo "0";
    }
    
    desconecta($conexao);
?>