<?php
    require '../utils/basics.php';

    $email = $_POST['email'];

    $conexao = conecta();
    if(!conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysql_select_db('heroku_98860801524147b', $conexao);
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    $query = "SELECT * FROM users WHERE email = '$email'";

    $select = mysql_query($query, $conexao);

    if($select){
        setcookie("login", $email);
        echo"<script language='javascript' type='text/javascript'>alert('Usuário logado com sucesso!');window.location.href='login.html'</script>";
        //Mudar dependendo do destino
        header("Location: index.php");
    } else {
        echo"<script language='javascript' type='text/javascript'>alert('Não foi possível cadastrar esse usuário');window.location.href='cadastro.html'</script>";
    }
    desconecta($conexao);
?>