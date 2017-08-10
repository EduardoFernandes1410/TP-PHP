<?php
    require '../utils/basics.php';

    session_start();
    $json = $_POST['usuarioInfo'];

    $obj = json_decode($json, true);

    $email = $obj['Email'];
    $cpf = $obj['CPF'] || "";
    $admin = $obj['Admin'];
    $contato = $obj['Contato'] || "";
    $rua = $obj['Rua'] || "";
    $numero = $obj['Numero'] || "";
    $cidade = $obj['Cidade'] || "";
    $complemento = $obj['Complemento'] || "";
    $nome = $obj['Nome'];
    $foto = $obj['Foto'];
    $id = $obj['ID'];

    $conexao = conecta();

    if(!$conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    $query = "INSERT INTO user (id, email, cpf, contato, rua, numero, complemento, cidade, nome, foto, admin) VALUES ('$id', '$email', '$cpf', '$telefone', '$rua', '$numero', '$complemento', '$cidade', '$nome', '$foto', '$admin')";

    $insert = mysqli_query($conexao, $query);

    if($insert){
        echo "Deu bom";
    } else {

        //SE não cadastrar, ele já está cadastrado

        $query2 = "SELECT * FROM user WHERE id = '$id'";

        $select = mysqli_query($conexao, $query2);

        if(mysqli_num_rows($select) > 0){
            //Dados do usuário p/ sessão
            
            $sessao = [];
            while($row = mysqli_fetch_assoc($select)){
                $sessao['Email'] = $row['email'];
                $sessao['CPF'] = $row['cpf'];
                $sessao['Admin'] = $row['admin'];
                $sessao['Contato'] = $row['contato'];
                $sessao['Rua'] = $row['rua'];
                $sessao['Numero'] = $row['numero'];
                $sessao['Complemento'] = $row['complemento'];
                $sessao['Cidade'] = $row['cidade'];
                $sessao['Nome'] = $row['nome'];
                $sessao['Foto'] = $row['foto'];
                $sessao['ID'] = $row['id'];
            }
            $_SESSION = $sessao;

            var_dump($_SESSION);
        } else {
            echo "Deu ruim";
        }            
    }
    desconecta($conexao);
?>