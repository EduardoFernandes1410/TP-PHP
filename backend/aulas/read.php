<?php
    require '../utils/basics.php';

    session_start();

    $conexao = conecta();
    if(!$conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    $query = "SELECT * FROM aula";

    $insert = mysqli_query($conexao, $query);

    if($insert){
        $aula = [];
        while($row = mysqli_fetch_assoc($insert)){
            $id = $row['sensei'];
            $nome = "";
            $query2 = "SELECT * FROM user WHERE id='$id'";

            $search = mysqli_query($conexao, $query2);
            if($search){
                if(mysqli_num_rows($search) > 0){
                    //Id é unico, logo só uma row é mudada
                    $nome = mysqli_fetch_assoc($search)['nomeSensei'];
                } else {
                    $nome = "????";
                }
            }
            $row['nome'] = $nome;

            array_push($aula, $row);
        }
        var_dump($aula);
    } else {
        echo "Não tem aulas";    
    }
    desconecta($conexao);
?>