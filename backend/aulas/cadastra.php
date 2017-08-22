<?php
    require '../utils/basics.php';

    $obj = json_decode(file_get_contents("php://input"));

    $nome = $obj->nome;
    $admin = $obj->sensei;
    $preco = $obj->preco;
    $tags = $obj->tags;
    $local = $obj->local;
    $data = $obj->data;
    $capacidade = $obj->capacidade;
    $id = uniqid();

	$conexao = conecta();

	if(!$conexao){
		die("Conexao nao pode ser feita");
	}

	$db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
	if(!$db_selected){
		die("Database não pode ser usada");
	}
    

    $query = "INSERT INTO aula (id, nome, sensei, preco, local, data, capacidade) VALUES ('$id', '$nome', '$admin', '$preco', '$local', '$data', '$capacidade')";

    $insert = mysqli_query($conexao, $query);

    if($insert){
        foreach($tags as $tag){
            $query2 = "INSERT INTO aula_tags (id_tag, id_aula) VALUES ('$tag', '$id')";
            $insert2 = mysqli_query($conexao, $query2);
        }
        echo true;
    } else {
        echo false;
    }
    
    desconecta($conexao);
?>