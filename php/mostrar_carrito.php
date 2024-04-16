<?php
    session_start();
    $ruta = '../';
    if (!empty($_SESSION['carrito'])) {
        require('conexion.php');
        require_once('encabezado.php');
        $conexion = conectar();
        if ($conexion) {
            $consulta = 'SELECT * FROM juego WHERE id_juego = ?';
            $sentencia = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($sentencia, 'i', $id);
            mysqli_stmt_bind_result($sentencia, $id, $titulo, $jugadores, $lanzamiento, $genero, $portada);

            echo '<main>';
            echo '<h3>Su carrito contiene: </h3>';
            echo '<table class="table table-bordered"style="width:80%; margin: 0 auto">
            <tr><th>Titulo</th><th>Portada</th><th>Genero</th><th>Jugadores</th><th>Cantidad</th>';
            foreach ($_SESSION['carrito'] as $id => $cant) {
                mysqli_stmt_execute($sentencia);
                mysqli_stmt_fetch($sentencia);
                echo '<tr><td class="col1">' . $titulo . '</td>';
                echo '<td><img class="prod-s" src="../img/portadas/' . $portada . '"></td>';
                echo '<td class="col1">' . $genero . '</td>';
                echo '<td class="col1">' . $jugadores . '</td>';
                echo '<td class="col1">' . $cant . '</td>';
            }
            mysqli_stmt_close($sentencia);
            echo '</table>';
        }
    }
?>