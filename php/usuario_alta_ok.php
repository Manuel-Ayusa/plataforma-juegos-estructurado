<?php
    session_start();
    $ruta = '../';
    if (!empty($_SESSION['usuario']) && !empty($_SESSION['tipo'])) {
?>
    <?php
        if (!empty($_POST['usuario']) && !empty($_POST['pass']) && !empty($_POST['tipo']) && !empty($_FILES['foto']['size'])) {
            require_once('conexion.php');
            $tipoDeArchivo = $_FILES['foto']['type'];
            $conexion = conectar();
            if ($conexion && ($tipoDeArchivo == 'image/jpeg' || $tipoDeArchivo == 'image/jpg' || $tipoDeArchivo == 'image/png' || $tipoDeArchivo == 'image/avif' || $tipoDeArchivo == 'image/webp')) {
                $usuarioForm = $_POST['usuario'];
                $contraseñaForm = sha1($_POST['pass']);
                $tipoForm = $_POST['tipo'];
                $nombreFoto = $_FILES['foto']['name'];
                $ext = explode('.', $nombreFoto);
                $cant = count($ext) - 1;
                $nombreFoto = $usuarioForm . '.' . $ext[$cant];

                $consulta = 'INSERT INTO usuario(usuario, pass, tipo, foto)
                             VALUE (?, ?, ?, ?)';
                $sentencia = mysqli_prepare($conexion, $consulta);
                mysqli_stmt_bind_param($sentencia, 'ssss', $usuarioForm, $contraseñaForm, $tipoForm, $nombreFoto);
                $q = mysqli_stmt_execute($sentencia);

                /* Mover foto */
                $origen = $_FILES['foto']['tmp_name'];
                $destino =  '../img/usuarios/' . $nombreFoto;
                $envio = move_uploaded_file($origen, $destino);

                if ($q && $envio) {
                    header('refresh:5;url=usuario_alta.php');
                    require_once('encabezado.php');
                    echo '<main>';
                    echo '<p>Guardado exitoso.</p>';
                    echo '</main>';
                } else {
                    header('refresh:5;url=usuario_alta.php');
                    require_once('encabezado.php');
                    echo '<main>';
                    echo '<p>Error al guardar.</p>';
                    echo '</main>';
                }

            } else {
                header('refresh:5;url=usuario_alta.php');
                require_once('encabezado.php');
                echo '<main>';
                echo '<p>Ocurrio algo inesperado. Intentelo nuevamente.</p>';
                echo '</main>';
            }
            desconectar($conexion);    
        } else {
            header('refresh:5;url=usuario_alta.php');
            require_once('encabezado.php');
            echo '<main>';
            echo '<p>Faltan datos.</p>';
            echo '</main>';
        }
        
    ?>
</main>
<?php
} else {
    header('refresh:0;url=../index.php');
    require_once('encabezado.php');
}
    require_once("pie.php");
?>