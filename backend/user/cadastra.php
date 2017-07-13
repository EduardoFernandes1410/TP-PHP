<?php
    require '../utils/basics.php';

    session_start();
    $json = $_POST['usuarioInfo'];

    $obj = json_decode($json, true);

    $email = $obj['Email'];
    $cpf = $obj['CPF'] || "";
    $admin = $obj['Admin'];
    $contato = $obj['Contato'] || "";
    $endereco = $obj['Endereco'] || "";
    $nome = $obj['Nome'];
    $foto = $obj['Foto'];
    $id = $obj['ID'];

    $conexao = conecta();
    if(!conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysql_select_db('heroku_98860801524147b', $conexao);
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    $query = "INSERT INTO user (id, email, cpf, contato, endereco, nome, foto, admin) VALUES ('$id', '$email', '$cpf', '$telefone', '$endereco', '$nome', '$foto', '$admin')";

    $insert = mysql_query($query, $conexao);

    if($insert){
        echo "Deu bom";
    } else {

        //SE não cadastrar, ele já está cadastrado

        $query2 = "SELECT * FROM user WHERE id = '$id'";

        $select = mysql_query($query2, $conexao);

        if(mysql_num_rows($select) > 0){
            //Dados do usuário p/ sessão
            $sessao = [];
            while($row = mysql_fetch_assoc($select)){
                $sessao['Email'] = $row['email'];
                $sessao['CPF'] = $row['cpf'];
                $sessao['Admin'] = $row['admin'];
                $sessao['Contato'] = $row['contato'];
                $sessao['Endereco'] = $row['endereco'];
                $sessao['Nome'] = $row['nome'];
                $sessao['Foto'] = $row['foto'];
                $sessao['ID'] = $row['id'];
            }
            $sessao = json_encode($sessao);

            $_SESSION['usuarioInfo'] = $sessao;

            echo $sessao;
        } else {
            echo "Deu ruim";
        }            
    }
    desconecta($conexao);
?>