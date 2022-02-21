<?php
    require 'config/config.php';

    $Destino = new Destino();
    $mensaje = 'No se pudo modificar el destino';
    $css     = 'danger';
    if( $Destino->modificarDestino() ){
        $mensaje = 'Destino: '.$Destino->getDestNombre().' modificado correctamente';
        $css     = 'success';
    }
    include 'includes/header.html';
    include 'includes/nav.php';
?>

    <main class='container'>

        <h1>Modificación de un destino</h1>

        <div class="alert alert-<?= $css ?> col-8 mx-auto">
            <?= $mensaje ?>
            <a href="adminDestinos.php" class="btn btn-light">Volver a panel</a>
        </div>

    </main>

<?php
    include 'includes/footer.php';
?>