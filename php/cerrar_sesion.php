<?php
    session_start();

    if ($_SESSION['usuario']) {
        header('refresh:0;url=../index.php');
        require_once('encabezado.php');
        session_destroy();
    } else {
        header('refresh:3;url=../index.php');
        require_once('encabezado.php');
        echo '<p>Usted no inicio session</p>';
    }
?>