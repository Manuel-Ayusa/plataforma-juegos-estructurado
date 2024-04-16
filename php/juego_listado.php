<?php
    session_start();
    $ruta = '../';
    if (!empty($_SESSION['usuario'])) {
        require("encabezado.php");
?>

<main class="container">
    <section class="row">
        <section class="col-3 menu pt-4">
            <?php require("menu.php"); ?>
        </section>
        <article class="col-9 listado pt-2">
            <?php
                echo '<section class="col-9 m-0 p-0"><p class="btn btn-primary float-end "><a href="mostrar_carrito.php" class="bi bi-cart text-white">Mi carrito</a></p></section>';
                require("conexion.php");
                $conexion = conectar();
                if ($conexion) {
                    //consulta SQL para obtener los juegos
                    $consulta = 'SELECT * FROM juego';
                    $sentencia = mysqli_prepare($conexion, $consulta);
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
                                    
                                    <img src="../img/portadas/<?php echo $portadaBD;//muestra la portada ?>" />
                                    
                                    <section class="card-content p-3">
                                        <h4 class="card-title text-center"><?php echo $tituloBD; //muestra el titulo ?></h4>
                                        <p class="">Jugadores: <?php echo $jugadoresBD;//muestra los jugadores ?></p>
                                        <p class="">Fecha de lanzamiento: <?php echo $lanzamientoBD;//muestra la fecha de lanzamiento ?></p>
                                        <p class="btn btn-primary"><?php echo $generoBD;//muestra el género ?></p>
                                        <p class="btn btn-success"><a href="reservar.php?id=<?php echo $idBD;?>" class="bi bi-cart text-white"></a></p>
                                    </section>
                                    <?php
                                        if ($_SESSION['tipo'] == 'Administrador') {
                                    ?>    
                                    
                                    <section class="mb-4">
                                        <a href="eliminar_juego.php?id=<?php echo $idBD;?>" class="bi bi-trash text-white btn btn-danger float-end mx-2"></a>
                                        <a href="modificar_juego.php?id=<?php echo $idBD;?>" class="bi bi-pencil text-white btn btn-primary float-end mx-2"></a>
                                    </section>
                                    <?php
                                        }
                                    ?>
                                </section>
                            </section>
                            <?php
                        }
                    } else {
                        echo '<h2>No hay resultados</h2>';
                    }
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