<?php
    require '../utils/basics.php';

    $materias = $_POST['materias'];
    $capacidade = $_POST['capacidade'];
    $data = $_POST['data'];
    $local = $_POST['local'];
    $preco = $_POST['preco'];
    $sensei = $_POST['sensei'];
    $nome = $_POST['nome'];
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

    $query = "INSERT INTO usuarios (id, email, cpf, telefone, endereco, nome, foto) VALUES ('$id', '$email', '$cpf', '$telefone', '$endereco', '$nome', '$foto')";

    $insert = mysql_query($query, $conexao);

    if($insert){
        echo"<script language='javascript' type='text/javascript'>alert('Usuário cadastrado com sucesso!');window.location.href='login.html'</script>";
    } else {
        echo"<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar esse usuário');window.location.href='cadastro.html'</script>";
    }
    desconecta($conexao);
?>