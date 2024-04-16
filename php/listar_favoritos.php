<?php
    session_start();
    $ruta = '../';
    require("encabezado.php");
    if (!empty($_SESSION['usuario'])) {
?>

<main class="container">
    <section class="row">
        <section class="col-3 menu pt-4">
            <?php require("menu.php"); ?>
        </section>
        <article class="col-9 listado pt-2">
            <?php
                require("conexion.php");
                $conexion = conectar();
                if ($conexion && !empty($_COOKIE[$_SESSION['usuario']])) {
                    //consulta SQL para obtener los juegos
                    $genero = $_COOKIE[$_SESSION['usuario']];
                    $consulta = 'SELECT * FROM juego WHERE genero = ?';
                    $sentencia = mysqli_prepare($conexion, $consulta);
                    mysqli_stmt_bind_param($sentencia, 's',$genero);
                    $q = mysqli_stmt_execute($sentencia);
                    mysqli_stmt_bind_result($sentencia, $idBD, $tituloBD, $jugadoresBD, $lanzamientoBD, $generoBD, $portadaBD);
                    mysqli_stmt_store_result($sentencia);
                    $cantidad = mysqli_stmt_num_rows($sentencia);
                    if ($cantidad > 0) {
                        while (mysqli_stmt_fetch($sentencia)) {
                            if ($portadaBD == '') {
                                $portadaBD = 'portada_default.png';
                            }
                            ?>
                            <section class="col-5 mt-2 mb-2">
                                <section class="card">
                                    <img src="../img/portadas/<?php echo $portadaBD;//muestre la portada ?>" />
                                    
                                    <section class="card-content p-3">
                                        <h4 class="card-title text-center"><?php echo $tituloBD; //muestre el titulo ?></h4>
                                        <p class="">Jugadores: <?php echo $jugadoresBD;//muestre los jugadores ?></p>
                                        <p class="">Fecha de lanzamiento: <?php echo $lanzamientoBD;//muestre la fecha de lanzamiento ?></p>
                                        <p class="btn btn-primary"><?php echo $generoBD;//muestre el género ?></p>
                                    </section>
                                </section>
                            </section>
                            <?php
                        }
                    } else {
                        echo '<h2>No hay resultados</h2>';
                    }
                }  else {
                    echo '<h2>No tiene favoritos</h2>';
                }
                ?>
        </article>
    </section>
</main>

<?php
    } else {
        header('refresh:0;url=../index.php');
        require("encabezado.php");
    }
    require("pie.php");
?>