<?php
    require '../utils/basics.php';

    session_start();
    $obj = json_decode($_POST['cadastroUsuario']);
    $cpf = $obj->Cpf;
    $contato = $obj->Fone;
    $rua = $obj->Rua;
    $numero = $obj->Numero;
    $cidade = $obj->Cidade;
    $complemento = $obj->Complemento;

    $id = $_SESSION['ID'];

    $conexao = conecta();
    if(!$conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysql_select_db('heroku_98860801524147b', $conexao);
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    $query = "UPDATE user SET cpf=\"$cpf\", admin=1, contato=\"$contato\", rua=\"$rua\", numero=\"$numero\", cidade=\"$cidade\", complemento=\"$complemento\" WHERE id=\"$id\"";

    var_dump($query);

    $insert = mysql_query($query, $conexao);    

    if($insert){
        $sessao['CPF'] = $cpf;
        $sessao['Admin'] = $admin;
        $sessao['Contato'] = $contato;
        $sessao['Rua'] = $rua;
        $sessao['Numero'] = $numero;
        $sessao['Complemento'] = $complemento;
        $sessao['Cidade'] = $cidade;
        
        $_SESSION = $sessao;

        echo "Deu bom";
    } else {
        echo "Deu ruim";
    }
    desconecta($conexao);
?>