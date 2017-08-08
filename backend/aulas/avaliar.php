<?php
    require '../utils/basics.php';

    session_start();

    $json = $_POST['info'];

    $obj = json_decode($json, true);

    $sensei = $obj['sensei'];
    $gafanhoto = $obj['gafanhoto'];
    $aula = $obj['aula'];
    $nota = $obj['nota'];

    $conexao = conecta();
    if(!$conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    $query1 = "SELECT * FROM notas WHERE id_aula = '$aula' and id_gafanhoto='$gafanhoto'";

    $select = mysqli_query($conexao, $query1);

    if(mysqli_num_rows($select) > 0){
        //A pessoa já deu nota p/ a aula, logo não pode dar nota mais
        echo "Já deu nota para essa aula";
    }
    else {
        //Dar nota p/ essa aula
        $query = "INSERT INTO notas (id_gafanhoto, id_aula, id_sensei, nota) VALUES ('$gafanhoto', '$aula', '$sensei', '$nota')";

        $insert = mysqli_query($conexao, $query);

        if($insert){
            echo "Nota dada com sucesso";
        } else {
            echo "Deu algum problema";
        }
    }    
    desconecta($conexao);
?>