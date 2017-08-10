<?php
    require '../utils/basics.php';

    session_start();
    
    $obj = json_decode(file_get_contents("php://input"));
    
    $cpf = $obj->Cpf;
    $contato = $obj->Fone;
    $rua = $obj->Rua;
    $numero = $obj->Numero;
    $cidade = $obj->Cidade;
    $complemento = $obj->Complemento;

    $id = $_SESSION['ID'];
    $isadmin = $_SESSION['Admin'];

    if($isadmin == 1)
        echo "2";
    else{
        $conexao = conecta();

        if(!$conexao){
            die("Conexao nao pode ser feita");
        }

        $db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
        if(!$db_selected){
            die("Database não pode ser usada");
        }

        $query = "UPDATE user SET cpf=\"$cpf\", admin=1, contato=\"$contato\", rua=\"$rua\", numero=\"$numero\", cidade=\"$cidade\", complemento=\"$complemento\" WHERE id=\"$id\"";

        $insert = mysqli_query($conexao, $query);    

        if($insert){
            $_SESSION['CPF'] = $cpf;
            $_SESSION['Admin'] = 1;
            $_SESSION['Contato'] = $contato;
            $_SESSION['Rua'] = $rua;
            $_SESSION['Numero'] = $numero;
            $_SESSION['Complemento'] = $complemento;
            $_SESSION['Cidade'] = $cidade;
            
            echo "1";
        } else {
            echo "0";
        }
        desconecta($conexao);
    }
?>