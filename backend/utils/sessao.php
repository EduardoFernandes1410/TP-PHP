<?php
    if(session_start()){
        echo $_SESSION;
    } else {
        echo "Nenhuma sessão ativa.";
    }
?>