<?php
    session_start();
    $ruta = '../';
    if (!empty($_SESSION['usuario']) && !empty($_SESSION['tipo'])) {
        if ($_SESSION['tipo'] == 'Administrador') {
        require("encabezado.php");
?>

<main class="container">
    <section class="row">
        <section class="col-3 menu pt-4">
            <?php require("menu.php"); ?>
        </section>
        <section class="col-9">
            <article class="row">
                <section class="menu_tmp">
                    <a class="btn btn-dark" href="usuario_alta.php">+ Alta usuario</a>
                </section>
                <table class="table table-bordered table-hover table-striped w-auto">
                    <caption class="caption-top text-center bg-dark">Listado de usuarios</caption>
                    <tr>
                        <th class="bg-secondary text-white">Foto</th>
                        <th class="bg-secondary text-white">Usuario</th>
                        <th class="bg-secondary text-white">Tipo</th>
                        <th class="bg-secondary text-white">Modificar</th>
                        <th class="bg-secondary text-white">Eliminar</th>
                        <th class="bg-secondary text-white">Desactivar</th>
                    </tr>

                    <?php
                        require_once('conexion.php');
                        $conexion = conectar();
                        if ($conexion) {
                            $activo = 'S'; 
                            $consulta = 'SELECT usuario, foto, tipo, id_usuario FROM usuario WHERE activado = ?';
                            $sentencia = mysqli_prepare($conexion, $consulta);
                            mysqli_stmt_bind_param($sentencia, 's', $activo);
                            $q = mysqli_stmt_execute($sentencia);
                            mysqli_stmt_bind_result($sentencia, $usuarioDB, $nombreFotoDB, $tipoDB, $id_usuarioDB);

                            if ($q) {
                                while (mysqli_stmt_fetch($sentencia)) {
                                    if ($nombreFotoDB != '') {
                                        echo '<tr>';
                                        echo '<td><img src="../img/usuarios/'. $nombreFotoDB . '"></td>';
                                        echo '<td>' . $usuarioDB .'</td>';
                                        echo '<td>' . $tipoDB .'</td>';
                                        echo '<td><a href="modificacionUsu.php?id=' . $id_usuarioDB . '"><img src="../img/iconos/modificar.png"></a></td>';
                                        echo '<td><a href="eliminacionUsu.php?id=' . $id_usuarioDB . '"><img src="../img/iconos/eliminar.png"></a></td>';
                                        echo '<td><a href="desactivacionUsu.php?id=' . $id_usuarioDB . '"><img src="../img/iconos/desactivar.png"></a></td>';
                                        echo '</tr>';        
                                    } else {
                                        echo '<tr>';
                                        echo '<td><img src="../img/usuarios/usuario_default.png"></td>';
                                        echo '<td>' . $usuarioDB .'</td>';
                                        echo '<td>' . $tipoDB .'</td>';
                                        echo '<td><a href="modificacionUsu.php?id=' . $id_usuarioDB . '"><img src="../img/iconos/modificar.png"></a></td>';
                                        echo '<td><a href="eliminacionUsu.php?id=' . $id_usuarioDB . '"><img src="../img/iconos/eliminar.png"></a></td>';
                                        echo '<td><a href="desactivacionUsu.php?id=' . $id_usuarioDB . '"><img src="../img/iconos/desactivar.png"></a></td>';
                                        echo '</tr>';        
                                    }
                                }
                            }
        
                        }
                        
                        desconectar($conexion);
                        
                    ?>
                </table>
            </article>
        </section>
    </section>
</main>

<?php
    } else {
        header('refresh:0;url=juego_listado.php');
    }
} else {
    header('refresh:0;url=../index.php');
    require("encabezado.php");
}
    require("pie.php");
?>