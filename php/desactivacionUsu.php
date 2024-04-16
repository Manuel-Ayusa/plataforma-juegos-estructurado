<?php
    session_start();
    $ruta = '../';
    if (!empty($_SESSION['usuario'])) {
?>
    <?php
        require_once('conecxion.php');
        $conexion = conectar();
        if ($conexion && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $activo = 'N';
            $consulta = 'UPDATE usuario SET activado = ? WHERE id_usuario = ?';
            $sentencia = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($sentencia, 'si', $activo, $id);
            $q = mysqli_stmt_execute($sentencia);
            if ($q) {
                header('refresh:3;url=usuario_listado.php');
                require_once ('encabezado.php');
                echo '<main>';
                echo '<p class="container text-center">¡Desactivacion exitosa!';
                echo '</main>';
            }
        }
        desconectar($conexion);
    ?>
</main>
<?php
} else {
    header('refresh:0;url=../index.php');
    require_once ('encabezado.php');
}
    require_once ('pie.php');
?>