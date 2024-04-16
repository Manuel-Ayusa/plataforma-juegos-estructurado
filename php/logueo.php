<?php
    session_start();
    $ruta = '../';
   
    if (!empty($_POST['usuario']) && !empty($_POST['pass'])) {
        //hacer cuestiones
        require_once('conexion.php');
        $conexion = conectar();
        if ($conexion) {
            $usuarioForm = $_POST['usuario'];
            $contraseñaForm = sha1($_POST['pass']);
            $activo = 'S';
            $consulta = 'SELECT foto, tipo 
                         FROM usuario 
                         WHERE usuario = ? AND pass = ? AND activado = ?';
            $sentencia = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($sentencia, 'sss', $usuarioForm, $contraseñaForm, $activo);
            $q = mysqli_stmt_execute($sentencia);
            mysqli_stmt_bind_result($sentencia, $foto, $tipo);
            if (mysqli_stmt_fetch($sentencia)) {
                header('refresh:0;url=juego_listado.php');
                require_once('encabezado.php');
                $_SESSION['usuario'] = $usuarioForm;
                $_SESSION['tipo'] = $tipo;
                if ($foto != '') {
                    $_SESSION['foto'] = $foto;
                } else {
                     $_SESSION['foto'] = 'usuario_default.png';
                }
            } else {
                header('refresh:3;url=../index.php');
                require_once('encabezado.php');
                echo '<p>Usuario o contraseña incorrectos.</p>';
            }
        }
        desconectar($conexion);
    } else {
        header('refresh:3;url=../index.php');
        require_once('encabezado.php');
        echo '<p>Faltan datos.</p>';
    }
    require_once('pie.php');
?>