<?php

session_start();

if (isset($_SESSION["id"])) {
    header("Location: ../templates/painel-usuario.php");
    exit;
}

header("Location: ../templates/login.php");
exit;