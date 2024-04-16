<?php
    session_start();
    $ruta = '../';
    if (!empty($_SESSION['usuario'])) {
        require_once('conexion.php');
        $conexion = conectar();
        if ($conexion && !empty($_GET['id'])) {

            $id = $_GET['id'];
            if (empty($_SESSION['carrito'])) {
                $_SESSION['carrito'] = array();
            }
            if (empty($_SESSION['carrito'][$id])) {
                $_SESSION['carrito'][$id] = 1;
            } else {
                $_SESSION['carrito'][$id]++; 
            }
            header('refresh:3;url=juego_listado.php');
            require_once('encabezado.php');
            echo '<main>';
            echo '<p>Se guardo un producto en el carrito.</p>';
            echo '</main>';
        }
        desconectar($conexion);
    }
?>