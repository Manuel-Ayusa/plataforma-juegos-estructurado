<?php
    $ruta = '';
    require("php/encabezado.php");
?>
<main class="container">
    <article class="container py-5 h-100">
        <section class="row d-flex justify-content-center align-items-center h-100">
            <form action="php/logueo.php" method="post" class="col-12 col-md-8 col-lg-6 col-xl-5">
                <fieldset class="card bg-dark text-white" style="border-radius: 1rem;">
                    <section class="card-body p-5 text-center">
                        <h2 class="fw-bold mb-2">INICIAR SESIÓN</h2>
                        <p class="text-white-50 mb-5">Ingrese su mail y contraseña</p>

                        <section class="form-outline form-white mb-4">
                            <input type="text" id="user" name="usuario" required class="form-control form-control-lg" />
                            <label class="form-label" for="user">Usuario</label>
                        </section>

                        <section class="form-outline form-white mb-4">
                            <input type="password" id="pass" name="pass" required class="form-control form-control-lg" />
                            <label class="form-label" for="pass">Contraseña</label>
                        </section>

                        <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                    </section>
                </fieldset>
            </form>
        </section>
    </article>
</main>
<?php
    require("php/pie.php");
?>