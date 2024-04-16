<?php
    session_start();
    $ruta = '../';
    if (!empty($_SESSION['usuario'])) {
?>
    <?php
        require_once('conexion.php');
        $conexion = conectar();
        if ($conexion && !empty($_POST['usuario']) && !empty($_POST['pass']) && !empty($_POST['tipo']) && !empty($_POST['id'])) {
            $id = $_POST['id'];
            $usuario = $_POST['usuario'];
            $contrasenia = sha1($_POST['pass']);
            $tipo = $_POST['tipo'];
            if (!empty($_FILES['foto']['size'])) { /* Si el usuario carga una foto */
                $tipoDeArchivo = $_FILES['foto']['type'];
                if ($tipoDeArchivo == 'image/jpeg' || $tipoDeArchivo == 'image/jpg' || $tipoDeArchivo == 'image/png' || $tipoDeArchivo == 'image/avif' || $tipoDeArchivo == 'image/webp') {
                    $nombreFoto = $_FILES['foto']['name'];
                    $ext = explode('.', $nombreFoto);
                    $cant = count($ext) - 1;
                    $nuevoNombFoto = $usuario . '.' . $ext[$cant];
                    $origen = $_FILES['foto']['tmp_name'];
                    $destino = '../img/usuarios/' . $nuevoNombFoto;
                    $envio = move_uploaded_file($origen, $destino);
                } else {
                    $nuevoNombFoto = '';
                }
            } else { /* Si el usuario no carga una foto */
                $nombFotoAnt = $_POST['nombFotoAnt']; 
                if ($nombFotoAnt != '') { /* Si existia una foto guardada la borra y guarda una cadena de caracteres vacia */
                    $imgBorrar = '../img/usuarios/' . $nombFotoAnt; 
                    unlink($imgBorrar);
                    $nuevoNombFoto = '';
                } else { /* Si no solo guarda una cadena de caracteres vacia */
                    $nuevoNombFoto = '';
                }
            } 
        
            $consulta = 'UPDATE usuario SET usuario = ?, pass = ?, tipo = ?, foto = ? WHERE id_usuario = ?';
            $sentencia = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($sentencia, 'ssssi', $usuario, $contrasenia, $tipo, $nuevoNombFoto, $id);
            $q = mysqli_stmt_execute($sentencia);
            if ($q) {
                header('refresh:3; url="usuario_listado.php"');
                require_once('encabezado.php');
                echo '<main>';
                echo '<p class="container text-center">¡Actualizacion Exitosa!</p>';
                echo '</main>';
            }
 
        } else {
            header('refresh:3; url="usuario_listado.php"');
            require_once('encabezado.php');
            echo '<main>';
            echo '<p>¡Error!.Fallo la conexion o faltan datos.</p>';
            echo '</main>';
        }
        desconectar($conexion);
    ?>
<?php
    } else {
        header('refresh:0;url=../index.php');
        require_once('encabezado.php');
    }
    require_once('pie.php');
?>