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
            <h2 class="col-12 text-center mt-4">Preferencias</h2>
            <!-- Obtener los géneros mediante una consulta SQL (si así lo prefiere) -->
                <?php
                    require_once('conexion.php');
                    $conexion = conectar();
                    if ($conexion) {
                        $consulta = 'SELECT DISTINCT(genero) FROM juego ORDER BY genero';
                        $sentencia = mysqli_prepare($conexion, $consulta);
                        $q = mysqli_stmt_execute($sentencia);
                        mysqli_stmt_bind_result($sentencia, $genero);
                        mysqli_stmt_store_result($sentencia);
                        $cantFilas = mysqli_stmt_num_rows($sentencia);
                    }
                ?>
                            <form method="post" action="guardarCookie.php" class="col-5 mt-2 mb-2 p-2 bg-light border">
                                <legend class="text-center bg-secondary p-2">Género favorito</legend>
                                <label class="form-label mt-3">Elija el género:</label>
                                <select class="form-select" name="genero" id="gen">
                                    <!--etiquetas option a mano o bucle recorriendo los resultados de la consulta -->
                                    <?php
                                        if ($cantFilas > 0) {
                                            while (mysqli_stmt_fetch($sentencia)) {
                                                echo '<option value="' . $genero . '">' . $genero . '<option>';
                                            }
                                        }
                                    ?>
                                </select>
                                <section class="text-center">
                                    <input type="submit" value="Guardar" class="btn btn-success mt-3 mb-3">
                                </section>
                            </form>
        </article>
    </section>
</main>

<?php
    } else {
        header('refresh:o;url=../index.php');
        require("encabezado.php");
    }
    require("pie.php");
?>