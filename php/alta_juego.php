<?php
session_start();
    if (!empty($_SESSION['usuario']) && !empty($_SESSION['tipo'])) {
        if ($_SESSION['tipo'] == 'Administrador') {
        $ruta = '../';
        require_once("encabezado.php");
?>
<main class="container col-md-6 bg-light"> 
    <h2 class="bg-warning text-center p-2">Nuevo juego</h2>
    <form action="guardar_juego.php" method="post" enctype="multipart/form-data">
        <section class="pt-2">
            <label for="tit" class="form-label">Titulo:</label>
            <input type="text" name="titulo" id="tit" class="form-control">
        </section>
        <section class="pt-2">
            <label for="jug" class="form-label">Jugadores:</label>
            <input type="number" name="jugadores" id="jug" class="form-control">
        </section>
        <section class="pt-2">
            <label for="fec" class="form-label">Lanzamiento:</label>
            <input type="date" name="lanzamiento" id="fec" class="form-control">
        </section>
        <section class="pt-2">
            <label for="gen" class="form-label" class="form-label">Genero</label>
            <select name="genero" id="gen" class="form-control">
                <option value="Accion">Accion</option>
                <option value="Aventura">Aventura</option>
                <option value="Terror">Terror</option>
                <option value="Deportes">Deportes</option>
                <option value="Guerra">Guerra</option>
            </select>
        </section>
        <section class="pt-2">
            <label for="port" class="form-label">Portada:</label>
            <input type='hidden' name= 'MAX_FILE_SIZE' value= '6300000'>
            <input type="file" name="portada" id="port" accept="image/*" class="form-control">
        </section>
        <section class="text-center pt-2 pb-2">
            <input type="submit" value="Guardar" class="btn btn-success">
        </section>
    </form>
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