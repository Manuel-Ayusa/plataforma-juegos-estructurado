<?php
    session_start();
    $ruta = '../';
    if ($_SESSION['usuario'] && $_SESSION['tipo'] == 'Administrador') {
        require_once('conexion.php');
        require_once('encabezado.php');
        $conexion = conectar();
        if ($conexion && !empty($_GET['id'])) {
            $idForm = $_GET['id'];
            $consulta = 'SELECT titulo, genero FROM juego WHERE id_juego = ?';
            $sentencia = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($sentencia, 'i', $idForm);
            $q = mysqli_stmt_execute($sentencia);
            mysqli_stmt_bind_result($sentencia, $tituloJuego, $genero);
            mysqli_stmt_store_result($sentencia);
            $cantFilas = mysqli_stmt_num_rows($sentencia);
            if ($cantFilas > 0) {
                while (mysqli_stmt_fetch($sentencia)) {
                    echo '<p>¿Esta seguro que quiere eliminar el Titulo: <b>' . $tituloJuego . '</b>, del Genero: <b>' . $genero . '</b>?</p>';
                    echo '<a class="btn btn-success m-2" href="eliminar_juego_Ok.php?id=' . $idForm . '">Aceptar</a>';
                    echo '<a class="btn btn-danger m-2" href="juego_listado.php">Cancelar</a>';
                }
            }
        }
        desconectar($conexion);
    }
?>