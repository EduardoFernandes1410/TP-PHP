<?php
    require '../utils/basics.php';

    $obj = $_POST['usuarioInfo'];

    $json = json_decode($obj, true);

    var_dump($json);

    $email = $json['Email'];
    $cpf = $json['CPF'] || "";
    $admin = $json['Admin'];
    $contato = $json['Contato'] || "";
    $endereco = $json['Endereco'] || "";
    $nome = $json['Nome'];
    $foto = $json['Foto'];
    $id = $json['ID'];

    $conexao = conecta();
    if(!conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysql_select_db('heroku_98860801524147b', $conexao);
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    $query = "INSERT INTO user (id, email, cpf, contato, endereco, nome, foto, admin) VALUES ('$id', '$email', '$cpf', '$telefone', '$endereco', '$nome', '$foto', '$admin')";

    $insert = mysql_query($query, $conexao);

    if($insert){
        echo "Deu bom";
    } else {
        echo "/html/home.html";
    }
    desconecta($conexao);
?>