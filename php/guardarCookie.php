<?php
    session_start();
    if ($_SESSION['usuario']) {
        if (!empty($_POST['genero'])) {
            header('refresh:3;url=preferencias.php');
            $usuario = $_SESSION['usuario'];
            $genero = $_POST['genero'];
            $ruta = 'listar_favoritos.php';
            $guardar = setcookie($usuario, $genero, time() + 60 * 24 * 60 * 60, $ruta);
            if ($guardar) {
                header('refresh:3;url=juego_listado.php');
                require_once('encabezado.php');
                echo '<p>Preferencia guardada con exito.</p>';
            } else {
                header('refresh:3;url=juego_listado.php');
                require_once('encabezado.php');
                echo '<p>No se pudo guardar la preferencia.</p>';
            }
        } else {
            echo '<p>Faltan datos</p>';
        }        
    } else {
        header('refresh:0;url=../index.php');
        require_once('encabezado.php');
    }

?>