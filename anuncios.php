<?php 
require './includes/funciones.php';
incluirTemplate('header'); 
?>

    <main class="contenedor seccion">

        <h2>Casas y Depas en Venta</h2>
        <?php 
        $limite = 1000;
        require '../bienesRaicesPHP/includes/templates/anuncios.php'
        ?>
    </main>

    <?php incluirTemplate('footer')?>

 
</body>
</html>