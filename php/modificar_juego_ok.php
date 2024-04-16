<?php
    session_start();
    $ruta = '../';
    if ($_SESSION['usuario'] && $_SESSION['tipo'] == 'Administrador') {
        require_once('conexion.php');
        $conexion = conectar();
        if ($conexion && !empty($_POST['id']) && !empty($_POST['titulo']) && !empty($_POST['genero']) && !empty($_POST['jugadores']) && !empty($_POST['lanzamiento'])) {
            $id = $_POST['id'];
            $titulo = $_POST['titulo'];
            $genero = $_POST['genero'];
            $jugadores = $_POST['jugadores'];
            $lanzamiento = $_POST['lanzamiento'];
            if (!empty($_FILES['portada']['size'])) {
                $tipoArchivo = $_FILES['portada']['type'];
                if ($tipoArchivo == 'image/webm' || $tipoArchivo == 'image/jpg' || $tipoArchivo == 'image/jpeg' || $tipoArchivo == 'image/avif' || $tipoArchivo == 'image/png') {
                    $nombreFoto = $_FILES['portada']['name'];
                    $ext = explode('.', $nombreFoto);
                    $cant = count($ext);
                    $tituloGuion = explode(' ', $titulo);
                    $tituloGuion = implode('_', $tituloGuion);
                    $nuevoNombreFoto = $tituloGuion . '.' . $ext[$cant - 1];
                    $origen = $_FILES['portada']['tmp_name'];
                    $destino = '../img/portadas/' . $nuevoNombreFoto;
                    $envio = move_uploaded_file($origen, $destino);
                } else {
                    $nuevoNombreFoto = '';
                }
            }
            if ($_POST['nombreFotoAnt'] != '') {
                unlink('../img/portadas/' . $_POST['nombreFotoAnt']);    
            }
            $consulta = 'UPDATE juego SET titulo = ?, jugadores = ?, lanzamiento = ?, genero = ?, portada = ? WHERE id_juego = ?';
            $sentencia = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($sentencia, 'sisssi', $titulo, $jugadores, $lanzamiento, $genero, $nuevoNombreFoto, $id);
            $q = mysqli_stmt_execute($sentencia);
            
            if ($q) {
                header('refresh:3;url=juego_listado.php');
                require_once('encabezado.php');
                echo '<main>';
                echo '<p>Actualizacion exitosa.</p>';
                echo '</main>';
            } else {
                header('refresh:3;url=juego_listado.php');
                require_once('encabezado.php');
                echo '<main>';
                echo '<p>Algo salio mal.</p>';
                echo '</main>';
            }
        } else {
            header('refresh:3;url=juego_listado.php');
            require_once('encabezado.php');
            echo '<main>';
            echo '<p>Faltan Datos.</p>';
            echo '</main>';
        }
    }
    desconectar($conexion);
?>