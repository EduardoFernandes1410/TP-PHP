<?php
    require '../utils/basics.php';

    session_start();

    $json = $_POST['info'];

    $obj = json_decode($json, true);

    $user = $obj['user'];
    $aula = $obj['aula'];

    $conexao = conecta();
    if(!$conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    $query1 = "SELECT * FROM aula WHERE id_aula = '$aula'";

    $select = mysqli_query($conexao, $query1);

    if(mysqli_num_rows($select) > 0){
        //Capacidade da aula
        $capacidade = 1;
        while($row = mysqli_fetch_assoc($select)){
            $capacidade = $row['capacidade'];
        }
        if($capacidade == 0){
            echo "Aula cheia";
        } else {
            //Coloca o meliante na aula

            $capacidade = $capacidade - 1;
            
            $query = "INSERT INTO aula_user (id_user, id_aula) VALUES ('$user', '$aula')";

            $insert = mysqli_query($conexao, $query);

            if(!$insert){
                echo "Deu ruim";
            } else {
                //Atualiza a capacidade da aula

                $query2 = "UPDATE aula SET capacidade=$capacidade WHERE id='$aula'";

                $insert2 = mysqli_query($conexao, $query2);

                if($insert2){
                    echo "Aluno cadastrado com sucesso";
                } else {
                    echo "Deu ruim";
                }
            }
        }
    } else {
        echo "Não existe aula com esse id";
    }            

    
    desconecta($conexao);
?>

<?php
/*    require '../utils/basics.php';

    session_start();
    $obj = json_decode(file_get_contents("php://input"));

    $email = $obj->Email;
    $nome = $obj->Nome;
    $foto = $obj->Foto;
    $id = $obj->ID;

    $conexao = conecta();
    if(!conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysqli_select_db('heroku_98860801524147b', $conexao);
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    $query = "INSERT INTO user (id, email, cpf, contato, rua, numero, complemento, cidade, nome, foto, admin) VALUES ('$id', '$email', '$cpf', '$telefone', '$rua', '$numero', '$complemento', '$cidade', '$nome', '$foto', 0)";

    $insert = mysqli_query($query, $conexao);

    if($insert){
        echo "Deu bom";
    } else {

        //SE não cadastrar, ele já está cadastrado

        $query2 = "SELECT * FROM user WHERE id = '$id'";

        $select = mysqli_query($query2, $conexao);

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
            $sessao = json_encode($sessao);

            $_SESSION = $sessao;

            echo $sessao;
        } else {
            echo "Deu ruim";
        }            
    }
    desconecta($conexao);*/
?>