<?php
    session_start();
    $ruta = '../';
    if ($_SESSION['usuario'] && $_SESSION['tipo'] == 'Administrador') {
        require_once('encabezado.php');
        require_once('conexion.php');
        $conexion = conectar();
        if ($conexion && !empty($_GET['id'])) {
            $id = $_GET['id'];
            $consulta = 'SELECT titulo, jugadores, lanzamiento, genero, portada FROM juego WHERE id_juego = ?';
            $sentencia = mysqli_prepare($conexion, $consulta);
            mysqli_stmt_bind_param($sentencia, 'i', $id);
            $q = mysqli_stmt_execute($sentencia);
            mysqli_stmt_bind_result($sentencia, $titulo, $jugadores, $lanzamiento, $genero, $portada);
            mysqli_stmt_store_result($sentencia);
            $cantFilas = mysqli_stmt_num_rows($sentencia);
            if ($cantFilas > 0) {
                mysqli_stmt_fetch($sentencia);
            }
        }
    }
?>
<main class="container col-md-6 bg-light"> 
    <h2 class="bg-warning text-center p-2">Modificar juego</h2>
    <form action="modificar_juego_ok.php" method="post" enctype="multipart/form-data">
        <section class="pt-2">
            <label for="tit" class="form-label">Titulo:</label>
            <input type="text" name="titulo" value="<?php echo $titulo;?>" id="tit" class="form-control">
        </section>
        <section class="pt-2">
            <label for="jug" class="form-label">Jugadores:</label>
            <input type="number" name="jugadores" value="<?php echo $jugadores;?>" id="jug" class="form-control">
        </section>
        <section class="pt-2">
            <label for="fec" class="form-label">Lanzamiento:</label>
            <input type="date" name="lanzamiento" value="<?php echo $lanzamiento;?>" id="fec" class="form-control">
        </section>
        <section class="pt-2">
            <label for="gen" class="form-label" class="form-label">Genero</label>
            <select name="genero" id="gen" class="form-control">
            <?php
                    switch ($genero) {
                        case 'Survival':
                          echo  '<option value="Survival" selected>Survival</option>
                                <option value="Rol">Rol</option>
                                <option value="Estrategia">Estrategia</option>
                                <option value="Deportes">Deportes</option>
                                <option value="Guerra">Guerra</option>';
                        break;
                        case 'Rol':
                            echo  '<option value="Survival" Accion</option>
                                  <option value="Rol" selected>>Aventura</option>
                                  <option value="Estrategia">Terror</option>
                                  <option value="Deportes">Deportes</option>
                                  <option value="Guerra">Guerra</option>';
                          break;
                          case 'Estrategia':
                            echo  '<option value="Survival" >Survival</option>
                                  <option value="Rol" >Rol</option>
                                  <option value="Estrategia" selected>Estrategia</option>
                                  <option value="Deportes">Deportes</option>
                                  <option value="Guerra">Guerra</option>';
                          break;
                          case 'Deportes':
                            echo  '<option value="Accion" >Accion</option>
                                  <option value="Aventura">Aventura</option>
                                  <option value="Terror">Terror</option>
                                  <option value="Deportes" selected>Deportes</option>
                                  <option value="Guerra">Guerra</option>';
                          break;
                          case 'Guerra':
                            echo  '<option value="Accion" >Accion</option>
                                  <option value="Aventura">Aventura</option>
                                  <option value="Terror">Terror</option>
                                  <option value="Deportes">Deportes</option>
                                  <option value="Guerra" selected>Guerra</option>';
                          break;
                        default:
                            break;
                    }
                ?> 
            </select>
        </section>
        <section class="pt-2">
            <label for="port" class="form-label">Portada:</label>
            <input type='hidden' name= 'MAX_FILE_SIZE' value= '6300000'>
            <input type='hidden' name= 'id' value= '<?php echo $id;?>'>
            <input type='hidden' name= 'nombreFotoAnt' value= '<?php echo $portada;?>'>
            <input type="file" name="portada" id="port" accept="image/*" class="form-control">
        </section>
        <section class="text-center pt-2 pb-2">
            <input type="submit" value="Guardar" class="btn btn-success">
        </section>
    </form>
</main>