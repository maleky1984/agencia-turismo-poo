<?php
    require 'config/config.php';

    $Region  = new Region;
    $mensaje = 'No se pudo agregar la región';
    $css     = 'danger';
    if( $Region->agregarRegion() ){
        $mensaje = 'Región: '.$Region->getRegNombre().' agregada correctamente';
        $css     = 'success';
    }
    include 'includes/header.html';
    include 'includes/nav.php';
?>

    <main class='container'>

        <h1>Alta de una región</h1>

        <div class="alert alert-<?= $css ?> col-8 mx-auto">
            <?= $mensaje ?>
            <a href="adminRegiones.php" class="btn btn-light">Volver a panel</a>
        </div>

    </main>

<?php
    include 'includes/footer.php';
?>