<?php
    session_start();
    $ruta = '../';
    require_once ('encabezado.php');
?>
<main class="container text-center">
    <?php
    if (!empty($_SESSION['usuario'])) {
        require_once('conexion.php');
        $conexion = conectar();
        if ($conexion && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $consulta = 'SELECT usuario, tipo, foto FROM usuario WHERE id_usuario = ?';
            $sentencia = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($sentencia, 'i', $id);
            $q = mysqli_stmt_execute($sentencia);
            mysqli_stmt_bind_result($sentencia, $usuarioDB, $tipoDB, $fotoDB);
            mysqli_stmt_store_result($sentencia);
            $cantFilas = mysqli_stmt_num_rows($sentencia);
            if ($cantFilas > 0) {
                mysqli_stmt_fetch($sentencia);
            }
        }
        desconectar($conexion);
    ?>
    <section class="row">
        <section class="col-3">
            <?php
                require_once('menu.php');
            ?>
        </section>
        <section class="col-9">
            <a class="btn btn-danger" href="usuario_listado.php">Cancelar</a>
            <form action="modificarOk.php" method="post" enctype="multipart/form-data" class="bg-secondary border-info">
                <legend class="bg-dark border-info text-center">Modificar Usuario</legend>     
                <section>
                    <label for="usuario" class="form-label">Usuario</label>
                    <input type="text" name="usuario" value="<?php echo $usuarioDB ?>" id="usuario" placeholder="Usuario" required maxlength="45" class="form-control border-warning">
                    <label for="pass" class="form-label">Contraseña</label>
                    <input type="password" name="pass" id="pass" placeholder="Contraseña" required maxlength="45" class="form-control border-warning">
                    <label for="tipo" class="form-label">Tipo</label>
                    <select name="tipo" id="tipo" class="form-select border-warning">
                        <option value="<?php echo $tipoDB ?>" selected disabled><?php echo $tipoDB ?>(actual)</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Común">Común</option>
                    </select>
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" name="foto" id="foto"  class="form-control border-warning">
                    <input type="hidden" name="id" value="<?php echo $id ?>" id="id">
                    <input type="hidden" name="nombFotoAnt" value="<?php echo $fotoDB ?>" id="ft">
                    <section class="text-center">
                        <input type="submit" name="enviar" value="Confirmar" class="btn btn-dark mt-3 mb-3">
                    </section>
                </section>
            </form>
        </section>
    </section>
<?php
    } else {
        header('refresh:0;url=../index.php');
        require_once ('encabezado.php');
    }
?>   
</main>
<?php
    require_once ('pie.php');
?>