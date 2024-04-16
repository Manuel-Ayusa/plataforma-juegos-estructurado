<?php
    session_start();
    $ruta = '../';
    if (!empty($_SESSION['usuario'])) {
?>
    <?php
        require_once('conexion.php');
        $conexion = conectar();
        if ($conexion && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $consulta = 'DELETE FROM usuario WHERE id_usuario = ?';
            $sentencia = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($sentencia, 'i', $id);
            $q = mysqli_execute($sentencia);

            if ($q) {
                header('refresh:4;url=usuario_listado.php');
                echo '<main class="container text-center">';
                require_once('encabezado.php');
                echo '<p class="m-4">¡Borrado exitoso!</p>';
                echo '</main>';
            } else {
                header('refresh:4;url=usuario_listado.php');
                echo '<main class="container text-center">';
                require_once('encabezado.php');
                echo '<p class="m-4">No se pudo borrar.</p>';
                echo '</main>';   
            }
        }
        desconectar($conexion);
    ?>
<?php
} else {
    header('refresh:0;url=../index.php');
    require_once('encabezado.php');
}
    require_once ('pie.php');
?>