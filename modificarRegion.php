<?php
    require 'config/config.php';
    $Region = new Region();
    $check = $Region->modificarRegion();

    $css     = 'danger';
    $mensaje = 'No se pudo modificar la regi´on: '.$Region->getRegNombre();
    if( $check ){
        $css = 'success';
        $mensaje = 'Region: '.$Region->getRegNombre().' modificada correctamente.';
    }
    include 'includes/header.html';
    include 'includes/nav.php';
?>


    <main class="container py-3">
        <h1>Modificación de una región</h1>

        <div class="alert alert-<?= $css ?> col-8 mx-auto">
            <?= $mensaje ?>
            <a href="adminRegiones.php" class="btn btn-light">Volver a panel</a>
        </div>
    
    </main>
<?php
    include 'includes/footer.php';
?>