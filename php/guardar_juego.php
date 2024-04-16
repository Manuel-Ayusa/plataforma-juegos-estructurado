<?php
session_start();
    if (!empty($_SESSION['usuario']) && !empty($_SESSION['tipo'])) {
        if ($_SESSION['tipo'] == 'Administrador') {
        $ruta = '../';
        require_once('encabezado.php');
?>
    <?php
        if (!empty($_POST['titulo']) && !empty($_POST['jugadores']) && !empty($_POST['lanzamiento']) && !empty($_POST['genero']) && !empty($_FILES['portada']['size']))
        {
            require_once('conexion.php');
            $conexion = conectar();
            if ($conexion) {
                $tipoDeArchivo = $_FILES['portada']['type'];
                if ($tipoDeArchivo == 'image/jpeg' || $tipoDeArchivo == 'image/jpg' || $tipoDeArchivo == 'image/png' || $tipoDeArchivo == 'image/avif' || $tipoDeArchivo == 'image/webp') {
                    $nombreOriginal = $_FILES['portada']['name'];
                    $nombre = $_POST['titulo'];
                    $longitudNombre = strlen($nombre);
                    for ($i=0; $i < $longitudNombre; $i++) { 
                        if ($nombre[$i] == ' ') {
                            $nombre[$i] = '_';
                        }
                    }
                    $origen = $_FILES['portada']['tmp_name'];
                    $ext = explode('.', $nombreOriginal);
                    $cant = count($ext) - 1; // componentes del arreglo - 1
                    $nuevoNombre = $nombre . '.' . $ext[$cant];
                    $destino = '../img/portadas/' . $nuevoNombre; // $ext[$cant] selecciona el ultimo valor del arreglo ext, que seria la extencion de la imagen(esto se hace por las imagenes que tienen mas de un punto en su nombre)
                    $envio = move_uploaded_file($origen, $destino);
                    
                    $lanzamiento = $_POST['lanzamiento'];
                    $jugadores = $_POST['jugadores'];
                    $genero = $_POST['genero'];
                    $titulo = $_POST['titulo'];

                    $consulta = 'INSERT INTO juego (titulo, jugadores, lanzamiento, genero, portada) VALUES (?, ?, ?, ?, ?)';
                    $sentencia = mysqli_prepare($conexion, $consulta);
                    mysqli_stmt_bind_param($sentencia, 'sisss', $titulo, $jugadores, $lanzamiento, $genero, $nuevoNombre);
                    $q = mysqli_stmt_execute($sentencia);
                    if ($q) {
                        header('refresh:3;url=juego_listado.php');
                        echo '<p>Juego guardado con exito</p>';
                    }
                    desconectar($conexion);
                } else {
                    echo '<p>Tipo de archivo no compatible.</p>';
                }
            }
        }
        else {
            header('refresh: 5 url=../index.php');
            echo '<main>';
            echo '<p>Faltan datos.</p>';
            echo '</main>';
        }    
    ?>  
</main>
<?php
        } else {
            header('refresh:0;url=juego_listado.php');
        }
    } else {
    header('refresh:0;url=../index.php');
    require("encabezado.php");
    }
    require_once('pie.php');
?>