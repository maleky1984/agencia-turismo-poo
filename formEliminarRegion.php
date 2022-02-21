<?php
    require 'config/config.php';
    $Region = new Region;
    $check = $Region->confirmarBaja();

    include 'includes/header.html';
    include 'includes/nav.php';
?>

    <main class="container">
        <h1>Baja de una región</h1>

<?php
    if ( $check ){
?>
        <div class="alert alert-danger col-6 mx-auto">
            <i class="bi bi-exclamation-triangle"></i>
            No se puede eliminar la región <?= $Region->getRegNombre() ?>
            ya que tiene los siguientes destinos relacionados:
            <ul>
        <?php foreach( $check as $destino ){  ?>
                <li><?= $destino->destNombre ?></li>
        <?php }  ?>
            </ul>
            <br>
            <a href="adminRegiones.php" class="btn btn-light mt-3">
                Volver a panel de regiones
            </a>
        </div>
<?php
    }else{
?>
        <div class="alert bg-light p-4 col-6 mx-auto shadow text-danger">
            Se eliminará la región:
            <span class="lead"><?= $Region->getRegNombre() ?></span>
            <form action="eliminarRegion.php" method="post">
                <input type="hidden" name="idRegion"
                       value="<?= $Region->getIdRegion() ?>">
                <input type="hidden" name="regNombre"
                       value="<?= $Region->getRegNombre() ?>">
                <button class="btn btn-danger my-3 px-4">Confirmar baja</button>
                <a href="adminRegiones.php" class="btn btn-outline-secondary">
                    Volver a panel de regiones
                </a>
            </form>
        </div>
<?php
    }
?>
    </main>

<?php  include 'includes/footer.php';  ?>