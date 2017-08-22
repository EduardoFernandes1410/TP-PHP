<?php
    require 'backend/utils/basics.php';

	$conexao = conecta();

	if(!$conexao){
		die("Conexao nao pode ser feita");
	}

	$db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
	if(!$db_selected){
		die("Database não pode ser usada");
	}

	setcookie("conexao", $conexao);
	header("Location: /html/login.html");
?>