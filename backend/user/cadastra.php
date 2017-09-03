<?php
    require '../utils/basics.php';

    session_start();
    $json = json_decode(file_get_contents("php://input"));
    
    $obj = $json;
    
    $email = $obj->Email || "";
    $cpf = $obj->CPF || "";
    $admin = $obj->Admin;
    $contato = $obj->Contato || "";
    $rua = $obj->Rua || "";
    $numero = $obj->Numero || "";
    $cidade = $obj->Cidade || "";
    $complemento = $obj->Complemento || "";
    $nome = $obj->Nome;
    $foto = $obj->Foto;
    $id = $obj->ID;

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

    //Agora pega os dados
    $query2 = "SELECT * FROM user WHERE id = '$id'";

    $select = mysqli_query($conexao, $query2);

    if(mysqli_num_rows($select) > 0){
        //Dados do usuário p/ sessão
        
        while($row = mysqli_fetch_assoc($select)){
            $_SESSION['Email'] = $row['email'];
            $_SESSION['CPF'] = $row['cpf'];
            $_SESSION['Admin'] = $row['admin'];
            $_SESSION['Contato'] = $row['contato'];
            $_SESSION['Rua'] = $row['rua'];
            $_SESSION['Numero'] = $row['numero'];
            $_SESSION['Complemento'] = $row['complemento'];
            $_SESSION['Cidade'] = $row['cidade'];
            $_SESSION['Nome'] = $row['nome'];
            $_SESSION['Foto'] = $row['foto'];
            $_SESSION['ID'] = $row['id'];
        }

        echo(json_encode($_SESSION));
    } else {
        echo "Deu ruim";
    }
    
    desconecta($conexao);
?>