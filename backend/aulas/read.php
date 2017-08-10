<?php
    require '../utils/basics.php';

    session_start();

    $query = "SELECT * FROM aula";

    $conexao = conecta();
    
    if(!$conexao){
        die("Conexao nao pode ser feita");
    }

    $db_selected = mysqli_select_db($conexao, 'heroku_98860801524147b');
    if(!$db_selected){
        die("Database não pode ser usada");
    }

    $insert = mysqli_query($conexao, $query);

    if($insert){
        $aula = [];
        while($row = mysqli_fetch_assoc($insert)){

            //Pega o nome do sensei da aula

            $id = $row['sensei'];
            $nome = "";
            $query2 = "SELECT * FROM user WHERE id='$id'";

            $search = mysqli_query($conexao, $query2);
            if($search){
                if(mysqli_num_rows($search) > 0){
                    //Id é unico, logo só uma row é mudada
                    $nome = mysqli_fetch_assoc($search)['nome'];
                }
            }
            $row['nomeSensei'] = $nome;

            //Pega as tags da aula
            
            $id_aula = $row['id'];
            $tagNames = [];
            $query3 = "SELECT * FROM aula_tags WHERE id_aula='$id_aula'";

            $search2 = mysqli_query($conexao, $query3);
            if($search2){
                if(mysqli_num_rows($search2) > 0){
                    //Pega os nomes das tags 
                    while($id_tags = mysqli_fetch_assoc($search2)){
                        $id_tag = $id_tags['id_tag'];
                        $query4 = "SELECT * FROM tags WHERE id='$id_tag'";

                        $search3 = mysqli_query($conexao, $query4);
                        if($search3){
                            //cada tag tem só um nome e id é unique
                            if(mysqli_num_rows($search3) > 0){
                                array_push($tagNames, mysqli_fetch_assoc($search3)['nome']);
                            }
                        }
                    }
                }
            }
            
            $row['tags'] = $tagNames;

            array_push($aula, $row);
        }

        $aula = json_encode($aula, JSON_UNESCAPED_UNICODE);

        echo $aula;
    } else {
        echo false;    
    }
    desconecta($conexao);
?>