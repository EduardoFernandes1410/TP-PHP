<?php
    if(session_start()){
        echo json_encode($_SESSION);
    } else {
        echo "Nenhuma sessão ativa.";
    }
?>