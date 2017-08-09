<?php
    function conecta(){
        $host = 'us-cdbr-iron-east-03.cleardb.net';
        $username = 'b89e529e3ad7c6';
        $password = '8eed2925';
        $conexao = mysqli_connect($host, $username, $password);

        if(!$conexao){
            return false;
        }

        $conexao->set_charset("utf8");

        $db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
        if(!$db_selected){
            die("Database não pode ser usada");
        }
        
        return $conexao;
    }

    function desconecta($conexao){
        mysqli_close($conexao);
    }
?>