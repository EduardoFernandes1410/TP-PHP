<?php
    function conecta(){
        $host = 'us-cdbr-iron-east-03.cleardb.net';
        $username = 'b89e529e3ad7c6';
        $password = '8eed2925';
        $conexao = mysql_connect($host, $username, $password);

        if(!$conexao){
            return false;
        }
        
        return $conexao;
    }

    function desconecta($conexao){
        mysql_close($conexao);
    }
?>