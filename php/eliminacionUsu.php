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
            $consulta = 'SELECT usuario FROM usuario WHERE id_usuario = ?';
            $sentencia = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($sentencia, 'i', $id);
            $q = mysqli_execute($sentencia);
            mysqli_stmt_bind_result($sentencia, $usuario);
            mysqli_stmt_store_result($sentencia);
            $cantFilas = mysqli_stmt_num_rows($sentencia);

            if ($cantFilas > 0) {
                echo '<h2 class="m-4">Eliminar Usuario</h2>';
                while (mysqli_stmt_fetch($sentencia)) {
                    echo '<p>¿Esta seguro/a de querer borar el usuario <b>' . $usuario . '</b>?</p>';
                    echo '<a class="btn btn-success m-2" href="eliminarOk.php?id=' . $id . '">Aceptar</a>';
                    echo '<a class="btn btn-danger m-2" href="usuario_listado.php">Cancelar</a>';
                }
            }
        } else {
            header('refresh:0;url=../index.php');
            require_once('encabezado.php');
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