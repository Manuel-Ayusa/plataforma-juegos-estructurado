<?php
    session_start();
    $ruta = '../';
    if ($_SESSION['usuario']) {
        require_once('conexion.php');
        $conexion = conectar();
        if ($conexion && !empty($_GET['id'])) {
            $idForm = $_GET['id'];
            $consulta = 'DELETE FROM juego WHERE id_juego = ?';
            $sentencia = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($sentencia, 'i', $idForm);
            $q = mysqli_stmt_execute($sentencia);
            if ($q) {
                header('refresh:3;url=juego_listado.php');
                require_once('encabezado.php');
                echo '<main>';
                echo '<p>Se elimino con exito.</p>';
                echo '</main>';
            }
        }
    }
?>