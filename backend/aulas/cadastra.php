<?php
    require '../utils/basics.php';

    $json = $_POST['dadosAula'];

    $obj = json_decode($json, TRUE);

    $nome = $obj['nome'];
    $admin = $obj['sensei'];
    $preco = $obj['preco'];
    $tags = $obj['tags'];
    $local = $obj['local'];
    $data = $obj['data'];
    $capacidade = $obj['capacidade'];
    $id = uniqid();

    $conexao = conecta();
    if(!conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysql_select_db('heroku_98860801524147b', $conexao);
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    //termina dps

    $query = "INSERT INTO aula (id, nome, admin, preco, local, data, capacidade) VALUES ('$id', '$nome', '$admin', '$preco', '$endereco', '$data', '$capacidade')";

    $insert = mysql_query($query, $conexao);

    if($insert){
        foreach($tags as $tag){
            $query2 = "INSERT INTO aula_tags (id_tag, id_aula) VALUES ('$tag', '$id')";
            $insert2 = mysql_query($query2, $conexao);
        }
    } else {
        echo"Deu ruim";
    }
    desconecta($conexao);
?>