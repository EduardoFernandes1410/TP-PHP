<?php
    require '../utils/basics.php';

    session_start();

    $obj = json_decode(file_get_contents("php://input"));

    $user = $obj->user;
    $aula = $obj->aula;

    $conexao = $_COOKIE['conexao'];
    if(!$conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
    if(!$db_selected){
        die("Database não pode ser usada");
    }
    $query1 = "SELECT * FROM aula WHERE id = '$aula'";
    $select = mysqli_query($conexao, $query1);

    if(mysqli_num_rows($select) > 0){
        
        //Capacidade da aula
        $capacidade = 1;
        while($row = mysqli_fetch_assoc($select)){
            $capacidade = $row['capacidade'];
        }
        if($capacidade == 0){
            echo "0";
        } else {
            //Coloca o meliante na aula
            $capacidade = $capacidade - 1;
            
            $query = "INSERT INTO aula_user (id_user, id_aula) VALUES ('$user', '$aula')";

            $insert = mysqli_query($conexao, $query);

            if(!$insert){
                echo "0";
            } else {
                //Atualiza a capacidade da aula

                $query2 = "UPDATE aula SET capacidade=$capacidade WHERE id='$aula'";

                $insert2 = mysqli_query($conexao, $query2);

                if($insert2){
                    echo "1";
                } else {
                    echo "0";
                }
            }
        }
    } else {
        echo "0";
    }
    
    desconecta($conexao);
?>