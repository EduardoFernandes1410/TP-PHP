<?php
    require '../utils/basics.php';

    $obj = $_POST['usuarioInfo'];

    var_dump($_POST);

    $json = $obj.json_decode($obj);

    $email = $json['email'];
    $cpf = $json['cpf'] || "";
    $admin = $json['admin'];
    $contato = $json['contato'] || "";
    $endereco = $json['endereco'] || "";
    $nome = $json['nome'];
    $foto = $json['foto'];
    $id = $json['id'];

    $conexao = conecta();
    if(!conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysql_select_db('heroku_98860801524147b', $conexao);
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    $query = "INSERT INTO usuarios (id, email, cpf, contato, endereco, nome, foto, admin) VALUES ('$id', '$email', '$cpf', '$telefone', '$endereco', '$nome', '$foto', '$admin')";

    $insert = mysql_query($query, $conexao);

    if($insert){
        echo "Deu bom";
    } else {
        echo "/html/home.html";
    }
    desconecta($conexao);
?>