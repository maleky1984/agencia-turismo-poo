<?php
    require 'config/config.php';

    $Destino = new Destino();
    $mensaje = 'No se pudo agregar el destino';
    $css     = 'danger';
    if( $Destino->agregarDestino() ){
        $mensaje = 'Destino: '.$Destino->getDestNombre().' agregado correctamente';
        $css     = 'success';
    }
    include 'includes/header.html';
    include 'includes/nav.php';
?>

    <main class='container'>

        <h1>Alta de un destino</h1>

        <div class="alert alert-<?= $css ?> col-8 mx-auto">
            <?= $mensaje ?>
            <a href="adminDestinos.php" class="btn btn-light">Volver a panel</a>
        </div>

    </main>

<?php
    include 'includes/footer.php';
?>