<?php
    require 'config/config.php';
    $Region  = new Region;
    $mensaje = 'No se pudo eliminar la región';
    $css     = 'danger';
    if( $Region->eliminarRegion() ){
        $mensaje = 'Región: '.$Region->getRegNombre().' eliminada correctamente';
        $css     = 'success';
    }
    include 'includes/header.html';
    include 'includes/nav.php';
?>

    <main class='container'>

        <h1>Baja de una región</h1>

        <div class="alert alert-<?= $css ?> col-8 mx-auto">
            <?= $mensaje ?>
            <a href="adminRegiones.php" class="btn btn-light">Volver a panel</a>
        </div>

    </main>

<?php
    include 'includes/footer.php';
?>